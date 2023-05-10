<?php

use xCloud\MigrationAssistant\Encrypter;
use xCloud\MigrationAssistant\xCloudOption;

class Test_Rest_Aai extends WP_Ajax_UnitTestCase
{
    static $authToken = 'GMIkeSfYI7cO97RkU6zczXYj50gwa2fm';
    static $encryptionKey = '97It6IYkNJeB4xmUmbkEkcvkylrEPXrz';

    public static function wpSetUpBeforeClass($factory)
    {
        $factory->post->create();
    }

    public function setup()
    {
        parent::setup();

        xCloudOption::set('settings', [
            'auth_token' => self::$authToken,
            'encryption_key' => self::$encryptionKey,
            'site_id' => 1,
        ]);
    }

    function rest_get($path, $query = [])
    {
        $request = new WP_REST_Request('GET', '/xcloud-migration/v1'.$path);
        $request->set_query_params(['auth_token' => self::$authToken, 'payload' => $query ? base64_encode(json_encode($query)) : null]);
        return rest_get_server()->dispatch($request);
    }

    function get_decrypted_data($response)
    {
        return (new Encrypter(self::$encryptionKey))->decrypt($response->get_data()['data']);
    }

    function test_rest_api_requies_authentication()
    {
        $request = new WP_REST_Request('GET', '/xcloud-migration/v1/abspath');

        $response = rest_get_server()->dispatch($request);

        $this->assertEquals(401, $response->get_status());
        $this->assertEquals('rest_forbidden', $response->get_data()['code']);

        // var_dump(xCloudOption::get('settings.auth_token'));

        // make sure it has auth token
        $this->assertEquals(self::$authToken, xCloudOption::get('settings.auth_token'));
    }

    function test_can_get_abspath()
    {
        $request = new WP_REST_Request('GET', '/xcloud-migration/v1/abspath');
        $request->set_query_params(['auth_token' => self::$authToken]);
        $response = rest_get_server()->dispatch($request);

        $this->assertEquals(200, $response->get_status());
        $this->assertNotEmpty($response->get_data()['data']);

        // lets crypt make sure it has the correct data
        $decrypted_data = $this->get_decrypted_data($response);
        $this->assertEquals(ABSPATH, $decrypted_data['abspath']);
    }

    function test_can_get_wp_config()
    {
        $request = new WP_REST_Request('GET', '/xcloud-migration/v1/wp_config');
        $request->set_query_params(['auth_token' => self::$authToken]);

        // remove config to simulate 500
        @unlink(ABSPATH.'wp-config.php');
        @unlink(dirname(ABSPATH).'/wp-config.php');
        $response = rest_get_server()->dispatch($request);
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('conifg_not_found', $response->get_data()['code']);

        // put back config
        copy(ABSPATH.'wp-config-sample.php', ABSPATH.'wp-config.php');
        $response = rest_get_server()->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);
        $wp_config = base64_decode($decrypted_data['content']);
        $this->assertContains('define( \'DB_NAME\', \'database_name_here\' );', $wp_config);

        // remove config to simulate 500 again
        @unlink(ABSPATH.'wp-config.php');
        $response = rest_get_server()->dispatch($request);
        $this->assertEquals('conifg_not_found', $response->get_data()['code']);

        // put back config in one folder up
        copy(ABSPATH.'wp-config-sample.php', dirname(ABSPATH).'/wp-config.php'); // put back config in one folder up
        $response = rest_get_server()->dispatch($request);
        $this->assertEquals(200, $response->get_status());

        // remove config again to cleanup
        @unlink(dirname(ABSPATH).'/wp-config.php'); // remove config again
    }

    function test_can_get_db_tables()
    {
        $request = new WP_REST_Request('GET', '/xcloud-migration/v1/db/tables');
        $request->set_query_params(['auth_token' => self::$authToken]);

        $response = rest_get_server()->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);

        $this->assertStringStartsWith('wpphpunittests_', $decrypted_data['tables'][0]);
        $this->assertStringStartsWith('wpphpunittests_', $decrypted_data['tables'][1]);
        $this->assertTrue(in_array('wpphpunittests_comments', $decrypted_data['tables']));
        $this->assertTrue(in_array('wpphpunittests_posts', $decrypted_data['tables']));
    }

    function test_can_get_db_table_structure()
    {
        global $wpdb;
        // test with no table
        $response = $this->rest_get('/db/table_structure');
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('no_table', $response->get_data()['code']);

        // // test with invalid table
        $response = $this->rest_get('/db/table_structure', ['table' => 'wpphpunittests_postsakjshdkj']);
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('table_not_found', $response->get_data()['code']);

        // // test with valid table
        $response = $this->rest_get('/db/table_structure', ['table' => 'wpphpunittests_posts']);
        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);
        $this->assertEquals('wpphpunittests_posts', $decrypted_data['table']);
        $this->assertStringStartsWith('CREATE TABLE `wpphpunittests_posts`', $decrypted_data['create_table']);
        $this->assertEquals($wpdb->get_var('SELECT count(*) FROM `wpphpunittests_posts`'), $decrypted_data['row_count']);

        // doesn't seem to run on actions
        // $this->assertEquals('wpphpunittests_posts', $decrypted_data['describe_table']->table);
    }

    function test_can_get_db_table_data()
    {
        // test with no table
        $response = $this->rest_get('/db/table_data');
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('no_table', $response->get_data()['code']);

        // // test with invalid table
        $response = $this->rest_get('/db/table_data', ['table' => 'wpphpunittests_postsakjshdkj']);
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('table_not_found', $response->get_data()['code']);

        // test with valid table
        $response = $this->rest_get('/db/table_data', ['table' => 'wpphpunittests_posts']);
        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);
        $this->assertEquals('wpphpunittests_posts', $decrypted_data['table']);
        $this->assertNotEmpty($decrypted_data['data'][0]['ID']);
        $this->assertNotEmpty($decrypted_data['data'][0]['post_title']);
        $this->assertEquals(10, $decrypted_data['next']);
    }

    function test_can_get_fs_structure()
    {
        // root
        $response = $this->rest_get('/fs/structure');
        $this->assertEquals(200, $response->get_status());

        $decrypted_data = $this->get_decrypted_data($response);

        $this->assertIsArray($decrypted_data['files']);
        $this->assertIsArray($decrypted_data['dirs']);

        $this->assertEquals(dirname(__DIR__).'/wordpress/', $decrypted_data['abspath']);
        $this->assertStringStartsWith(dirname(__DIR__).'/wordpress/wp-', $decrypted_data['dirs'][0]);
        $this->assertArrayHasKey(dirname(__DIR__).'/wordpress/index.php', $decrypted_data['files']);
        $this->assertArrayHasKey(dirname(__DIR__).'/wordpress/wp-config-sample.php', $decrypted_data['files']);
        $this->assertArrayHasKey(dirname(__DIR__).'/wordpress/wp-activate.php', $decrypted_data['files']);
        $this->assertArrayHasKey(dirname(__DIR__).'/wordpress/wp-login.php', $decrypted_data['files']);

        $indexPath = dirname(__DIR__).'/wordpress/index.php';

        $this->assertEquals(filesize($indexPath), $decrypted_data['files'][$indexPath]['size']);
        $this->assertEquals(hash_file('sha256', $indexPath), $decrypted_data['files'][$indexPath]['hash']);

        // wp-admin forlder
        $response = $this->rest_get('/fs/structure', ['root' => dirname(__DIR__).'/wordpress/wp-includes']);
        $this->assertEquals(200, $response->get_status());

        $decrypted_data = $this->get_decrypted_data($response);

        $this->assertEquals(dirname(__DIR__).'/wordpress/', $decrypted_data['abspath']);
        $this->assertTrue(count($decrypted_data['files']) > 50);
        $this->assertNotEmpty($decrypted_data['dirs']);

        // invalid_root, it should not be able to streamm files that are outside of wp dir
        $response = $this->rest_get('/fs/structure', ['root' => dirname(__DIR__, 2)]);
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('invalid_root', $response->get_data()['code']);
    }

    function test_can_skip_cache_directory()
    {
        mkdir(ABSPATH.'wp-content/cache/wp-rocket/somedir', 0777, true);

        for ($i = 1; $i <= 10; $i++) {
            file_put_contents(ABSPATH."wp-content/cache/wp-rocket/somedir/{$i}.txt", $i);
        }

        $response = $this->rest_get('/fs/structure', [
            'root' => ABSPATH.'wp-content/cache/wp-rocket'
        ]);

        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);

        $this->assertCount(0, $decrypted_data['files']);
        $this->assertCount(0, $decrypted_data['dirs']);
        $this->assertCount(0, $decrypted_data['unreadable']);

        // it should ignore some files like .git
        @mkdir(dirname(__DIR__).'/wordpress/.git');
        @file_put_contents(dirname(__DIR__).'/wordpress/.git/file.txt', 'hello');

        $response = $this->rest_get('/fs/structure', [
            'root' => dirname(__DIR__).'/wordpress/.git'
        ]);

        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);
        $this->assertEmpty(count($decrypted_data['files']) > 50);
        $this->assertEmpty($decrypted_data['dirs']);
    }

    function test_can_get_fs_read()
    {
        // no_file
        $response = $this->rest_get('/fs/read');
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('no_file', $response->get_data()['code']);

        // small file
        $response = $this->rest_get('/fs/read', ['file' => dirname(__DIR__).'/wordpress/index.php']);
        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);

        $fileContent = file_get_contents(dirname(__DIR__).'/wordpress/index.php');
        $fileSize = filesize(dirname(__DIR__).'/wordpress/index.php');

        $this->assertEquals($fileContent, base64_decode($decrypted_data['content']));
        $this->assertEquals(hash('sha256', $fileContent), $decrypted_data['hash']);

        // end_of_file
        $response = $this->rest_get('/fs/read', ['file' => dirname(__DIR__).'/wordpress/index.php', 'start' => $fileSize + 100]);
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('end_of_file', $response->get_data()['code']);

        // end_of_file
        $response = $this->rest_get('/fs/read', ['file' => dirname(__DIR__).'/wordpress/file-should-not-exists.php']);
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('file_not_found', $response->get_data()['code']);

        // invalid_root, it should not be able to streamm files that are outside of wp dir
        $response = $this->rest_get('/fs/read', ['file' => '/root/somepath']);
        $this->assertEquals(500, $response->get_status());
        $this->assertEquals('invalid_root', $response->get_data()['code']);
    }

    function test_can_get_fs_read_multiple_files()
    {
        $files = [
            dirname(__DIR__).'/wordpress/index.php' => 0,
            dirname(__DIR__).'/wordpress/wp-activate.php' => 0,
            dirname(__DIR__).'/wordpress/404-not-found.php' => 0,
        ];

        $response = $this->rest_get('/fs/read', ['files' => $files]);
        $this->assertEquals(200, $response->get_status());
        $decrypted_data = $this->get_decrypted_data($response);

        foreach ($decrypted_data as $file => $content) {
            if (strpos($file, '404-not-found.php') !== false) {
                $this->assertEquals('file_not_found', $content['code']);
                continue;
            }

            $fileContent = file_get_contents($file);

            $this->assertEquals($fileContent, base64_decode($content['content']));

            $this->assertEquals(hash('sha256', $fileContent), $content['hash']);
        }
    }
}