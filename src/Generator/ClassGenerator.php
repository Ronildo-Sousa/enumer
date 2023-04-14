<?php

declare(strict_types=1);

namespace Src\Generator;

use Exception;

class ClassGenerator
{
    public function generate(string $file_path, string $stub_path)
    {
        $path = $this->qualifyPath($file_path);
        var_dump($path);
        if (!$path) {
            throw new Exception('This file already exists');
        }

        $this->makeDirectory($path);
        file_put_contents($path, $this->buildClass($path, $stub_path));

        return $path;
    }

    private function qualifyPath(string $rawName)
    {
        $path = $this->qualifyClass($rawName);

        if (file_exists($path)) {
            return null;
        }

        return $path;
    }

    private function qualifyClass(string $name)
    {
        if (str_starts_with($name, $this->getDocumentRoot())) {
            return $name;
        }

        return $this->getDocumentRoot() . '/' . trim($name, '\\/');
    }

    private function getStub(string $stub): string
    {
        if (!file_exists($stub)) {
            throw new Exception('Stub not found');
        }

        return $stub;
    }

    private function getDocumentRoot()
    {
        return getcwd();
    }

    private function makeDirectory(string $path)
    {
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        return $path;
    }

    private function buildClass(string $class, string $stub)
    {
        $stub = file_get_contents($this->getStub($stub));
        $this->replaceNamespace($stub, $class);
        $this->replaceClassName($stub, $class);

        return $stub;
    }

    public function replacePlaceholder(string &$stub, string $class, string $action, array $placeholders)
    {
        foreach ($placeholders as $search) {
            $stub = str_replace(
                $search,
                [$this->$action($class)],
                $stub
            );
        }

        return $this;
    }

    private function replaceNamespace(string &$stub, string $class)
    {
        $searches = [
            ['{{ namespace }}', '{{ rootNamespace }}', '{{namespace}}'],
        ];

        $this->replacePlaceholder($stub, $class, 'getNamespace', $searches);
    }

    private function replaceClassName(string &$stub, string $class)
    {
        $searches = [
            ['{{ class }}', '{{class}}'],
        ];

        $this->replacePlaceholder($stub, $class, 'getClassName', $searches);
    }

    public function getNamespace(string $class)
    {
        $namespace = str_replace('/', '\\', str_replace(getcwd(), '', $class));
        $namespace = implode('\\', array_slice(explode('\\', $namespace), 1, -1));

        return ucfirst(trim($namespace, '\\')) . ';';
    }

    public function getClassName(string $class)
    {
        $name = str_replace('.php', '', array_slice(explode('/', $class), -1));

        return implode($name);
    }
}
