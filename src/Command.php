<?php
declare(strict_types=1);
namespace PHPCLI;

abstract class Command
{
    private $app;

    public $name;
    public $description;

    public $arguments = [];

    protected $registeredArguments = [];

    public function setApp(App $app = null)
    {
        $this->app = $app;
    }

    public function setArguments($arguments)
    {
        foreach ($this->arguments as $argument) {
            foreach ($arguments as $key => $value) {
                if ($argument === $key) {
                    $this->registeredArguments[$key] = $value;
                }
            }
        }
    }

    protected function getArgument(string $argument)
    {
        return $this->registeredArguments[$argument];
    }

    protected function run(string $commandName, array $arguments = [])
    {
        $command = $this->app->searchCommand($commandName);
        if (count($arguments) > 0) {
            $command->setArguments($arguments);
        }
        $command->execute();
    }
}
