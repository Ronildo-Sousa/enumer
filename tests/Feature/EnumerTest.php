<?php

declare(strict_types=1);

use Src\Enumer;

beforeEach(function () {
    $this->simpleJson = '{"Hearts": "H", "Diamonds": "D", "Clubs": "C", "Spades": "S"}';
    $this->complexJson = '[
        {
          "Rondonia": "RO"
        },
        {
          "Acre": "AC"
        },
        {
          "Amazonas": "AM"
        },
        {
          "Minas gerais": "MG"
        }
    ]';
});

afterEach(fn () => removeTempFiles());

it('should convert a simple json into a PHP enum', function () {
    $enumer = new Enumer();
    $enum_path = $enumer->convertJson($this->simpleJson, TEMP_DIRECTORY . '/Enums/Teste.php');
    $namespace = $enumer->getNamespace($enum_path);
    $name = $enumer->getClassName($enum_path);
    $enum_content = file_get_contents($enum_path);

    $enum = '\\' . str_replace(';', '', $namespace) . '\\' . $name;
    $cases = $enum::cases();
    $tryFrom = $enum::tryFrom('S');

    expect($enum_path)
      ->toBeFile()
      ->and($enum_content)
      ->toContain('enum', $namespace, $name)
      ->and($cases)
      ->toBeArray()
      ->and($cases[0]->name)
      ->toContain('Hearts')
      ->and($cases[0]->value)
      ->toContain('H')
      ->and($tryFrom->name)
      ->toBe('Spades');
});

it('should be able to convert a multi nivel json into a PHP enum', function () {
    $enumer = new Enumer();
    $enum_path = $enumer->convertJson($this->complexJson, TEMP_DIRECTORY . '/Enums/Teste2.php');
    $namespace = $enumer->getNamespace($enum_path);
    $name = $enumer->getClassName($enum_path);
    $enum_content = file_get_contents($enum_path);

    $enum = '\\' . str_replace(';', '', $namespace) . '\\' . $name;
    $cases = $enum::cases();
    $tryFrom = $enum::tryFrom('MG');

    expect($enum_path)
      ->toBeFile()
      ->and($enum_content)
      ->toContain('enum', $namespace, $name)
      ->and($cases)
      ->toBeArray()
      ->and($cases[0]->name)
      ->toContain('Rondonia')
      ->and($cases[0]->value)
      ->toContain('RO')
      ->and($tryFrom->name)
      ->toBe('MinasGerais');
});
