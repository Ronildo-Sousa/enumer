<?php

declare(strict_types=1);

use Src\Enumer;

require_once __DIR__ . '/vendor/autoload.php';

// $json = '{"Hearts": "H", "Diamonds": "D", "Clubs": "C", "Spades": "S"}';
$json = file_get_contents(__DIR__ . '/teste.json');
$enumer = new Enumer();
$a = $enumer->convert($json, 'src/teste.php');
$namespace = $enumer->getNamespace($a);
$name = $enumer->getClassName($a);
$enum = '\\' . str_replace(';', '', $namespace) . '\\' . $name;

var_dump(
    $enum::cases()
);
