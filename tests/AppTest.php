<?php

namespace PHPCLITeste;

use PHPCLI\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testHello()
    {
        ob_start();
        $app = new App([]);
        $app->run();
        $expected = "Welcome PHPCLI\nCommands:\n";
        $actual = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($expected, $actual);
    }

    public function testAddCommand()
    {
        ob_start();
        $command = new TestCommand();
        $app = new App([]);
        $app->addCommand($command);
        ob_end_clean();

        $this->assertEquals(1, $app->countCommands());
    }

    public function testAddSameCommand()
    {
        ob_start();
        $command = new TestCommand();
        $app = new App([]);
        $app->addCommand($command);
        $app->addCommand($command);
        ob_end_clean();

        $this->assertEquals(1, $app->countCommands());
    }

    public function testIssetCommand()
    {
        ob_start();
        $command = new TestCommand();
        $app = new App([]);
        $app->addCommand($command);
        ob_end_clean();

        $this->assertEquals(true, $app->issetCommand($command));
    }

    public function testSearchCommand()
    {
        ob_start();
        $command = new TestCommand();
        $app = new App([]);
        $app->addCommand($command);
        ob_end_clean();

        $this->assertEquals($command, $app->searchCommand('Test'));
    }
}
