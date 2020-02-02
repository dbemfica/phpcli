# PHP CLI
This is a lib simple to create commands in PHP using Command Line Interface

## Create APP
Create a file *index.php* with this content
```php
<?php

require_once "vendor/autoload.php";

$command = new \PHPCLI\FirstCommand();

$app = new \PHPCLI\App($argv);
$app->addCommand($command);
$app->run();
```
After run this script *php index.php*

## Create Command
```php
<?php

use PHPCLI\Command;

class FirstCommand extends Command
{
    public $name = "First";
    public $description = "Command Example";

    public $arguments = [
        'name'
    ];

    public function execute()
    {
        echo "First command";
    }
}
```

## Passing arguments to the command
os argumentos são pssando passados pelo bash com o prefixo --. Example *php index.php --name Diogo*
```php
<?php

use PHPCLI\Command;

class FirstCommand extends Command
{
    public $name = "First";
    public $description = "Command Example";

    public $arguments = [
        'name'
    ];

    public function execute()
    {
        $name = $this->getArgument('name');
        echo "Hello ".$name.PHP_EOL;
    }
}
```