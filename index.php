<?php

declare(strict_types=1);

use RonildoSousa\Enumer;

require_once __DIR__ . '/vendor/autoload.php';

$json = '{"Hearts": "H", "Diamonds": "D", "Clubs": "C", "Spades": "S"}';
// $json = file_get_contents(__DIR__ . '/teste.json');
// $json = '[
//     {
//       "Rondonia": "RO"
//     },
//     {
//       "Acre": "AC"
//     },
//     {
//       "Amazonas": "AM"
//     },
//     {
//       "Minas gerais": "MG"
//     }
// ]';
$enumer = new Enumer();
// $enum_path = $enumer->convertJson($json, __DIR__ . '/tests/temp/Enums/teste.php');
// $enum_path = __DIR__ . '/tests/temp/Enums/teste.php';
// $namespace = $enumer->getNamespace($enum_path);
// $name = $enumer->getClassName($enum_path);

// $enum =  str_replace(';', '', $namespace) . '\\' . $name;

// var_dump(
//     $enum::cases()
// );
