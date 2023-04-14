<?php

declare(strict_types=1);

use Src\Generator\ClassGenerator;

afterEach(fn () => removeTempDirectory());

it('should generate a class based on a stub', function (string $file_path, string $stub_path, string $file_type) {
    $classGenerator = new ClassGenerator();
    $newClass = $classGenerator->generate($file_path, $stub_path);

    $classContent = file_get_contents($newClass);
    $namespace = $classGenerator->getNamespace($newClass);
    $className = $classGenerator->getClassName($newClass);

    expect($newClass)
        ->toBeFile()
        ->and($classContent)
        ->toContain($file_type, $namespace, $className);
})->with([
    [
        TEMP_DIRECTORY . '/Enums/Enum.php',
        __DIR__ . '/../../src/stubs/enum.stub',
        'enum',
    ],
    [
        TEMP_DIRECTORY . '/Classes/MyClass.php',
        __DIR__ . '/../../src/stubs/class.stub',
        'class',
    ],
    [
        TEMP_DIRECTORY . '/Interfaces/MyInterface.php',
        __DIR__ . '/../../src/stubs/interface.stub',
        'interface',
    ],
]);
