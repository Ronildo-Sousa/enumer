<?php

declare(strict_types=1);

use Src\Generator\ClassGenerator;

require_once __DIR__ . '/vendor/autoload.php';

$e = (new ClassGenerator());
// $path = $e->makeDirectory('/teste');
// file_put_contents($path, $e->buildClass('Src\DTO\Teste.php'));
// $name = $e->qualifyClass('\app\Teste1.php');
// $path = $e->getPath($name);
// $e->makeDirectory($path);
// file_put_contents($path, $e->buildClass($name));
var_dump(
    // getcwd()
    $e->generate(
        __DIR__ . '/src/temp/teste.php',
        __DIR__ . '/src/stubs/Enum.stub'
    )
    // $name,
    // $path,
    // str_starts_with(__FILE__ . '/temp/classes/MyClass.php', getcwd())
    // trim('/Src\DTO\Teste.php', '\\/.php')
    // file_exists(__DIR__ . '/src/DTO/Teste.php')
    // file_get_contents((new Enumer)->getStub())
);
