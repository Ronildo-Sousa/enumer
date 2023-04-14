<?php

namespace Src\Generator;

use Exception;

class ClassGenerator
{
    public function generate(string $file_path, string $stub_path)
    {
        $path = $this->qualifyPath($file_path);
        if (!$path) {
            throw new Exception('This file already exists');
        }

        $this->makeDirectory($path);
        file_put_contents($path, $this->buildClass($path, $stub_path));

        return $path;
    }

    public function qualifyPath(string $rawName)
    {
        $path = $this->qualifyClass($rawName);

        if (file_exists($path)) {
            return null;
        }
        return $path;
    }

    public function qualifyClass(string $name)
    {
        if (str_starts_with($name, $this->getDocumentRoot())) {
            return $name;
        }

        return $this->getDocumentRoot() . '/' . trim($name, '\\/');
    }

    public function getStub(string $stub): string
    {
        if (!file_exists($stub)) {
            throw new Exception('Stub not found');
        }
        return $stub;
    }

    public function getDocumentRoot()
    {
        return getcwd();
    }

    public function makeDirectory(string $path)
    {
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        return $path;
    }

    public function buildClass(string $class, string $stub)
    {
        $stub = file_get_contents($this->getStub($stub));
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
        $namespace = str_replace('/', '\\', str_replace(getcwd(), '', $class));

        return ucfirst(trim($namespace, '\\'));
    }
}
