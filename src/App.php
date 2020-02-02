<?php
declare(strict_types=1);
namespace PHPCLI;

class App
{
    public $arguments;
    private $registeredCommands = [];
    private $command;

    public function __construct(array $arguments)
    {
        unset($arguments[0]);
        if (isset($arguments[1])) {
            $this->command = $arguments[1];
            unset($arguments[1]);
        }
        $arguments = array_values($arguments);

        for ($i = 0; $i < count($arguments); $i += 2) {
            $arguments2[str_replace("--", "", $arguments[$i])] = $arguments[$i+1];
            $this->arguments[str_replace("--", "", $arguments[$i])] = $arguments[$i+1];
        }
    }

    public function addCommand(Command $command)
    {
        if ($this->issetCommand($command)) {
            return false;
        }
        $command->setApp($this);
        array_push($this->registeredCommands, $command);
    }

    public function issetCommand(Command $command)
    {
        foreach ($this->registeredCommands as $registeredCommand) {
            if ($registeredCommand->name === $command->name) {
                return true;
            }
        }
        return false;
    }

    public function searchCommand(string $name)
    {
        foreach ($this->registeredCommands as $registeredCommand) {
            if ($registeredCommand->name === $name) {
                return $registeredCommand;
            }
        }
        return null;
    }

    public function countCommands()
    {
        return count($this->registeredCommands);
    }

    private function hello()
    {
        echo "Welcome PHPCLI".PHP_EOL;
        echo "Commands:".PHP_EOL;
        foreach ($this->registeredCommands as $command) {
            echo " - ".$command->name.": ".$command->description.PHP_EOL;
        }
    }

    public function run()
    {
        foreach ($this->registeredCommands as $registeredCommand) {
            if ($this->command === $registeredCommand->name) {
                if ($this->arguments !== null) {
                    $registeredCommand->setArguments($this->arguments);
                }
                $registeredCommand->execute();
                return true;
            }
        }
        $this->hello();
    }
}
