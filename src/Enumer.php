<?php

declare(strict_types=1);

namespace RonildoSousa;

use Exception;
use RonildoSousa\Generator\ClassGenerator;

class Enumer extends ClassGenerator
{
    private const STUB_PATH = __DIR__ . '/stubs/enum.stub';

    public function convertJson(string $json, string $file_path, string $returnType = 'string'): string
    {
        $json = $this->handleJson($json);
        $enumContent = $this->toEnum($json, $returnType);

        return $this->generate($file_path, self::STUB_PATH, $enumContent, $returnType);
    }

    public function toEnum(string $json, string $returnType = 'string'): string
    {
        $cases = json_decode($this->handleJson($json), true);

        $enumContent = '';
        foreach ($cases as $key => $value) {
            if ($returnType === 'string') {
                $enumContent .= 'case ' . str_replace(' ', '', mb_convert_case($key, MB_CASE_TITLE)) . ' = ' . '"' . $value . '"' . ';';
                continue;
            }
            $enumContent .= 'case ' . str_replace(' ', '', mb_convert_case($key, MB_CASE_TITLE)) . ' = ' . $value . ';';
        }

        return $enumContent;
    }

    private function handleJson(string $json): string
    {
        $cases = $this->validateJson($json);
        $content = '{';
        $i = 0;

        foreach ($cases as $case => $value) {
            if ($i < count($cases) && $i > 0) {
                $content .= ',';
            }

            if (is_array($value)) {
                foreach ($value as $key => $value) {
                    $content .= '"' . $key . '"' . ': ' . '"' . $value . '"';
                }
            } else {
                $content .= '"' . $case . '"' . ': ' . '"' . $value . '"';
            }
            $i++;
        }
        $content .= '}';

        return $content;
    }

    private function validateJson(string $json): array
    {
        $cases = json_decode($json, true);
        if (is_null($cases)) {
            throw new Exception('Could not convert json');
        }

        return $cases;
    }
}
