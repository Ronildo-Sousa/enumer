<?php

declare(strict_types=1);

namespace RonildoSousa\Generator;

use Exception;

class ClassGenerator
{
    public function generate(string $file_path, string $stub_path, string $content = '', string $returnType = 'string')
    {
        $path = $this->qualifyPath($file_path);
        if (!$path) {
            throw new Exception('This file already exists');
        }

        $this->makeDirectory($path);
        file_put_contents($path, $this->buildClass($path, $stub_path, $content, $returnType));

        return $path;
    }

    protected function qualifyPath(string $rawName): ?string
    {
        $path = $this->qualifyClass($rawName);

        if (file_exists($path)) {
            return null;
        }

        return $path;
    }

    protected function qualifyClass(string $name): string
    {
        if (str_starts_with($name, $this->getDocumentRoot())) {
            return $name;
        }

        return $this->getDocumentRoot() . '/' . trim($name, '\\/');
    }

    protected function getStub(string $stub): string
    {
        if (!file_exists($stub)) {
            throw new Exception('Stub not found');
        }

        return $stub;
    }

    protected function getDocumentRoot(): string
    {
        return getcwd();
    }

    protected function makeDirectory(string $path): string
    {
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        return $path;
    }

    protected function buildClass(string $class, string $stub, string $content = '', string $returnType = ''): string
    {
        $stub = file_get_contents($this->getStub($stub));

        $this->replaceNamespace($stub, $class);
        $this->replaceClassName($stub, $class);
        $this->replaceContent($stub, $class, $content);
        $this->replaceReturnType($stub, $class, $returnType);

        return $stub;
    }

    public function replacePlaceholder(string &$stub, string $class, string $action, array $placeholders, string $content = '', string $returnType = ''): self
    {
        foreach ($placeholders as $search) {
            $stub = str_replace(
                $search,
                [$this->$action($class, $content, $returnType)],
                $stub
            );
        }

        return $this;
    }

    protected function replaceReturnType(string &$stub, string $class, string $returnType)
    {
        $searches = [
            ['{{ returnType }}', '{{returnType}}']
        ];

        $this->replacePlaceholder(
            $stub,
            $class,
            'getReturnType',
            $searches,
            '',
            $returnType
        );
    }

    protected function replaceContent(string &$stub, string $class, string $content): void
    {
        $searches = [
            ['{{ content }}', '{{ body }}', '{{content}}', '{{body}}'],
        ];

        $this->replacePlaceholder($stub, $class, 'getContent', $searches, $content);
    }

    protected function replaceNamespace(string &$stub, string $class): void
    {
        $searches = [
            ['{{ namespace }}', '{{ rootNamespace }}', '{{namespace}}'],
        ];

        $this->replacePlaceholder($stub, $class, 'getNamespace', $searches);
    }

    protected function replaceClassName(string &$stub, string $class): void
    {
        $searches = [
            ['{{ class }}', '{{class}}'],
        ];

        $this->replacePlaceholder($stub, $class, 'getClassName', $searches);
    }

    protected function getReturnType(string $class, string $content, string $type): string
    {
        return $type;
    }

    public function getContent(string $class, string $content): string
    {
        $content = array_slice(explode(';', $content), 0, -1);
        $formatedContent = [];

        $formatedContent = array_map(
            fn ($item) => PHP_EOL . '   ' . $item . ';' . PHP_EOL,
            $content
        );

        return implode($formatedContent);
    }

    public function getNamespace(string $class): string
    {
        $class = explode('/', str_replace($this->getDocumentRoot(), '', $class));
        $class = array_slice($class, 1);

        if (str_contains($this->getDocumentRoot(), '/php/enumer')) {
            array_unshift($class, $this->getComposerNamespace());
        }

        $size = count($class);
        if ($size === 1) {
            array_unshift($class, $this->getComposerNamespace());
        }

        $namespace = implode('\\', array_slice($class, 0, -1));

        return $namespace . ';';
    }

    public function getClassName(string $class): string
    {
        $name = str_replace('.php', '', array_slice(explode('/', $class), -1));

        return implode($name);
    }

    private function getComposerNamespace(): string
    {
        $composer = json_decode(file_get_contents($this->getDocumentRoot() . '/composer.json'), true);

        return trim(key($composer['autoload']['psr-4']), '\\/');
    }
}
