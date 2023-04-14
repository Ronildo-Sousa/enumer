<?php

declare(strict_types=1);

use Src\Generator\ClassGenerator;

it('should generate a class based on a stub', function () {
    $stubPath = __DIR__ . '/../../src/stubs/Enum.stub';
    $file_path = __DIR__ . '/temp/classes/MyClass.php';

    $classGenerator = new ClassGenerator;

    $newClass = $classGenerator->generate($file_path, $stubPath);

    expect($newClass)
        ->toBeFile();
});
