<?php

namespace Moataz\SchemaObjectManager\Console;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Cache;
use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

abstract class SchemaObjectCommand extends GeneratorCommand
{
    abstract function type(): SchemaObjectType;

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        parent::handle();

        $key = Config::get('schema-objects.cache.key');

        Cache::set($key, array_merge(
            Cache::get($key),
            [$this->qualifyClass($this->argument('name'))]
        ));
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/' . strtolower($this->type()->value) . '.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $base = Config::get('schema-objects.namespace');

        if ($path = $this->option('path')) {
            $path = trim($path, '\\/');
            return $base . '\\' . str_replace('/', '\\', $path);
        }

        return $base;
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $objectName = $this->guessObjectName($name);

        return str_replace(
            '{{ name }}',
            $objectName,
            $stub
        );
    }

    protected function guessObjectName(string $class): string
    {
        return Str::snake(class_basename($class));
    }
}
