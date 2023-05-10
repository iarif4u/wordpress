<?php

use duncan3dc\Laravel\Drivers\ChromeProcess;
use duncan3dc\Laravel\Drivers\DriverInterface;
use duncan3dc\Laravel\Dusk;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverCapabilities;

class Test_Dusk extends WP_UnitTestCase
{
    function test_database_works()
    {
        $dusk = new Dusk(new Chrome);

        $dusk->visit("http://0.0.0.0:8881/wp-admin");

        $dusk->waitFor("#user_login", 15);

        $dusk->type('#user_login', 'admin');
        $dusk->type('#user_pass', 'password');
        $dusk->click('#wp-submit');

        $dusk->waitForLocation('/wp-admin/');

        $dusk->clickLink('xCloud Migration');
        $dusk->waitForText('xCloud Migration Assistant');
        $dusk->assertSee('Enter Your xCloud Token here');
        $dusk->type('#xcloud_migration_token', 'dasjhdajks');
        $dusk->click('#submit');
        $dusk->assertSee('Invalid token provided.');

        $dusk->visit("http://0.0.0.0:8881/wp-admin/admin.php?page=xcloud-migration-assistant");
        $dusk->type('#xcloud_migration_token',
            'J0uluS4JlZU78tKcXjY3qNsoNPuysNGLeyJpdiI6InkxREJ4bHdGRys3aFlMdHJOQTY4TXc9PSIsInZhbHVlIjoidldzUGx0N0Vmd0RHN0dRR0ZYOUlTQ3BDY3pFQmxZWjFXTmFUWlBPUUEzekFDa0plT1ZFS2hLRlZCMXFWaGZPdng4ZmtuQ2o1UjlCL2d1Z3dVMk1VVmlwbCtEK2tDUmF5TkNjMVh2bkd3WGRTd1RCVWJHTzZQYk8rM1hWQWxGaEQwUWpBVFJQay9IYUFJczczRG9xR0poUU94Ynh2M2lQV0htWm16cTVrZENVPSIsIm1hYyI6IjQxOTI2YTY2NmYyM2VkZDU4ZDcxMGRiYjc1NjU3ZTg4ZDRjNzBmYzhjY2YwNmQwNzUzOTAzZWIyMWJhMjMzNWIiLCJ0YWciOiIifQ==');
        // auth token o0nR7epJ4zGGAFGO1Dqi7ahOUcgFRZ8a
        // encryption Key hzEGCUTOItdZF6Z83G0BXRSJreS6fhEj

        $dusk->click('#submit');

        $dusk->assertSee('Site is ready to be migrated into xCloud');
    }
}


class Chrome implements DriverInterface
{
    /**
     * The port to run on.
     *
     * @var int
     */
    protected $port;

    /**
     * The Chromedriver process instance.
     *
     * @var \Symfony\Component\Process\Process
     */
    private $process;

    /**
     * @var WebDriverCapabilities $capabilities The capabilities in use.
     */
    protected $capabilities;


    /**
     * Create a new instance and automatically start the driver.
     */
    public function __construct(int $port = 9515)
    {
        $this->port = $port;

        $this->start();

        $capabilities = DesiredCapabilities::chrome();

        $options = (new ChromeOptions)->addArguments([
            // '--disable-gpu',
            '--headless',
            // '--no-sandbox',
            // '--verbose',
        ]);

        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $this->setCapabilities($capabilities);
    }


    /**
     * {@inheritDoc}
     */
    public function setCapabilities(WebDriverCapabilities $capabilities): void
    {
        $this->capabilities = $capabilities;
    }


    /**
     * {@inheritDoc}
     */
    public function getDriver(): RemoteWebDriver
    {
        return RemoteWebDriver::create("http://127.0.0.1:{$this->port}", $this->capabilities);
    }


    /**
     * Start the Chromedriver process.
     *
     * @return \duncan3dc\Laravel\Drivers\Chrome
     */
    public function start(): DriverInterface
    {
        if (!$this->process) {
            $this->process = (new ChromeProcess($this->port))->toProcess();
            $this->process->start();
            sleep(1);
        }

        return $this;
    }


    /**
     * Ensure the driver is closed by the upstream library.
     *
     * @return $this
     */
    public function stop(): DriverInterface
    {
        if ($this->process) {
            $this->process->stop();
            unset($this->process);
        }

        return $this;
    }


    /**
     * Automatically end the driver when this class is done with.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->stop();
    }
}
