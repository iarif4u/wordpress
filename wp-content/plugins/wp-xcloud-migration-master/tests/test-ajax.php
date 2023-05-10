<?php

class Test_Aajx extends WP_Ajax_UnitTestCase
{
    public static function wpSetUpBeforeClass($factory)
    {
        $factory->user->create(array('role' => 'administrator'));
    }

    public function setup()
    {
        parent::setup();

        wp_set_current_user(1);
    }

    function test_database_works()
    {
        global $wpdb;

        $this->assertEquals(2, $wpdb->get_var("SELECT count(*) FROM $wpdb->users"));
        $this->assertEquals(1, get_current_user_id());
    }

    function test_demo_wp_rest()
    {
        $request = new WP_REST_Request('GET', '/xcloud-migration/v1/abspath');

        $response = rest_get_server()->dispatch($request);

        $this->assertEquals(403, $response->get_status());
        $this->assertEquals('rest_forbidden', $response->get_data()['code']);
    }

    function test_get_statuses_rest_endpoint()
    {
        $request = new WP_REST_Request('GET', '/xcloud-migration/v1/get_statuses');

        $response = rest_get_server()->dispatch($request);

        $this->assertEquals(200, $response->get_status());
        $this->assertNotEmpty($response->get_data()['request_url']);
    }
}