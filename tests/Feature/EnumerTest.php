<?php

declare(strict_types=1);

use Src\Enumer;

beforeEach(function () {
    $this->simpleJson = '{"Hearts": "H", "Diamonds": "D", "Clubs": "C", "Spades": "S"}';
});

afterEach(fn () => removeTempDirectory());

it('should convert a json into a PHP enum', function () {
    $enumer = new Enumer;
    $enum = $enumer->convert($this->simpleJson, TEMP_DIRECTORY . '/Teste.php');

    expect($enum)
        ->toBeFile();
});
