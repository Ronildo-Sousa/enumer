<?php

declare(strict_types=1);

use Src\DTO\Teste;
use Src\Enumer;

require_once __DIR__ . '/vendor/autoload.php';

$e = (new Enumer());
// $path = $e->makeDirectory('/teste');
// file_put_contents($path, $e->buildClass('Src\DTO\Teste.php'));
$name = $e->qualifyClass('\app\Teste1.php');
$path = $e->getPath($name);
$e->makeDirectory($path);
file_put_contents($path, $e->buildClass($name));
var_dump(
    $name,
    $path,

    // file_exists(__DIR__ . '/src/DTO/Teste.php')
    // file_get_contents((new Enumer)->getStub())
);
