<?php

declare(strict_types=1);

namespace Src;

class Enumer
{
    public function alreadyExists(string $rawName)
    {
        return file_exists($this->getPath($this->qualifyClass($rawName)));
    }

    public function getPath(string $name)
    {
        $a = explode('\\', $name);
        $a = str_replace('.php', '', $a);
        $name = implode('/', $a);

        return $name . '.php';
    }

    public function qualifyClass(string $name)
    {
        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);

        $name = str_replace(
            $this->getDefaultNamespace(),
            '',
            mb_convert_case($name, MB_CASE_LOWER)
        );
        $name = str_replace('.php', '', $name);

        return $this->getDefaultNamespace() . '\\' . mb_convert_case($name, MB_CASE_TITLE) . '.php';
    }

    public function getStub(): string
    {
        return __DIR__ . '/stubs/Enum.stub';
    }

    public function getDefaultNamespace()
    {
        return 'src';
    }

    public function makeDirectory(string $path)
    {
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        return $path;
    }

    public function buildClass(string $class)
    {
        $stub = file_get_contents($this->getStub());

        $this->replaceNamespace($stub, $class);

        return $stub;
    }

    public function replaceNamespace(string &$stub, string $class)
    {
        $searches = [
            ['{{ namespace }}', '{{ rootNamespace }}'],
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getNamespace($class)],
                $stub
            );
        }

        return $this;
    }

    public function getNamespace(string $class)
    {
        return trim(implode('\\', array_slice(explode('\\', $class), 0, -1)), '\\');
    }
}
