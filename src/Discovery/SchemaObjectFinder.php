<?php

namespace Moataz\SchemaObjectManager\Discovery;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Moataz\SchemaObjectManager\Contracts\SchemaObject;

class SchemaObjectFinder
{
    public function discover(): array
    {
        if ($this->useCache() && Cache::has($this->cacheKey())) {
            return array_map(fn($class) => App::make($class), array_filter(Cache::get($this->cacheKey()), fn($class) => class_exists($class)));
        }

        $classes = [];
        $namespace = Config::get('schema-objects.namespace');
        $basePath = $this->namespaceToPath($namespace);

        if (!is_dir($basePath)) {
            return [];
        }

        foreach (File::allFiles($basePath) as $file) {

            if ($file->getExtension() !== 'php') {
                continue;
            }

            $class = $this->classFromFile($file->getPathname(), $namespace, $basePath);

            if (!class_exists($class)) {
                continue;
            }

            $ref = new ReflectionClass($class);

            if (
                !$ref->isAbstract() &&
                $ref->implementsInterface(SchemaObject::class)
            ) {
                $classes[] = $class;
            }
        }

        if ($this->useCache()) {
            Cache::forever($this->cacheKey(), $classes);
        }

        return array_map(fn($class) => App::make($class), $classes);
    }

    protected function namespaceToPath(string $namespace): string
    {
        return App::path(
            str_replace('\\', '/', str_replace('App\\', '', $namespace))
        );
    }

    protected function classFromFile(string $file, string $namespace, string $basePath): string
    {
        $relative = str_replace($basePath . '/', '', $file);

        $relative = str_replace(['/', '.php'], ['\\', ''], $relative);

        return $namespace . '\\' . $relative;
    }

    protected function cacheKey(): string
    {
        return Config::get('schema-objects.cache.key', '');
    }

    protected function useCache(): bool
    {
        return Config::get('schema-objects.cache.enabled', false);
    }

    public function clearCache(): void
    {
        Cache::forget($this->cacheKey());
    }
}
