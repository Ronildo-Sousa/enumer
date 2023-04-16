<?php

declare(strict_types=1);

use Src\Enumer;

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
$a = $enumer->convertJson($json, 'src/teste.php');
// $namespace = $enumer->getNamespace($a);
// $name = $enumer->getClassName($a);
// $enum = '\\' . str_replace(';', '', $namespace) . '\\' . $name;

// var_dump(

// );
