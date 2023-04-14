<?php

declare(strict_types=1);

namespace Src;

use Exception;
use Src\Generator\ClassGenerator;

class Enumer extends ClassGenerator
{
    private const STUB_PATH = __DIR__ . '/stubs/enum.stub';

    public function convert(string $json, string $file_path, string $returnType = 'string')
    {
        $cases = json_decode($json, true);
        if (is_null($cases)) {
            throw new Exception('Could not convert json');
        }

        $content = '';
        foreach ($cases as $key => $value) {
            $content .= 'case ' . mb_convert_case($key, MB_CASE_TITLE) . ' = ' . $value . ';';
        }

        return $this->generate($file_path, self::STUB_PATH, $content, $returnType);
    }
}
