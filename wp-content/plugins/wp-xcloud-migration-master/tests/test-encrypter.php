<?php

use xCloud\MigrationAssistant\Encrypter;

class Encrypter_Test extends WP_UnitTestCase
{
    function test_it_can_encrypt_and_decrypt()
    {
        $key = '3ZGK3VlyxKgef6wCmXZXstk2Yu5gwF3C';

        $encypted = (new Encrypter($key))->encrypt('test');

        $this->assertEquals('test', (new Encrypter($key))->decrypt($encypted));
    }

    function test_it_throws_exception_on_wrong_encryption_key()
    {
        $key = 'small_key';

        $this->expectException(RuntimeException::class);

        (new Encrypter($key))->encrypt('test');
    }

    function test_it_throws_exception_on_decryption_failure()
    {
        $key = '3ZGK3VlyxKgef6wCmXZXstk2Yu5gwF3C';
        $key2 = '3ZGK3VlyxKgef6wCmXZXstk2Yu5gwF3x';

        $encypted = (new Encrypter($key))->encrypt('test');

        $this->expectException(Exception::class);

        (new Encrypter($key2))->decrypt($encypted);
    }
}