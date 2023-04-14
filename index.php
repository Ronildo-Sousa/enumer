<?php

declare(strict_types=1);

use Src\Enumer;
use Src\Generator\ClassGenerator;

require_once __DIR__ . '/vendor/autoload.php';

$e = (new ClassGenerator());
// $path = $e->makeDirectory('/teste');
// file_put_contents($path, $e->buildClass('Src\DTO\Teste.php'));
// $name = $e->qualifyClass('\app\Teste1.php');
// $path = $e->getPath($name);
// $e->makeDirectory($path);
// file_put_contents($path, $e->buildClass($name));
$json = '{"Hearts": "H", "Diamonds": "D", "Clubs": "C", "Spades": "S"}';
var_dump(
    // getcwd()
    // $e->generate(
    //     __DIR__ . '/src/Action.php',
    //     __DIR__ . '/src/stubs/class.stub'
    // )
    // (new Enumer)->convert($json, 'src/')
    (new Enumer)->convert($json, 'src/teste.php', 'int')
    // $name,
    // $path,
    // str_starts_with(__FILE__ . '/temp/classes/MyClass.php', getcwd())
    // trim('/Src\DTO\Teste.php', '\\/.php')
    // file_exists(__DIR__ . '/src/DTO/Teste.php')
    // file_get_contents((new Enumer)->getStub())
);
