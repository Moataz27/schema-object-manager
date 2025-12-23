<?php

namespace Moataz\SchemaObjectManager\Engine;

use Illuminate\Support\Facades\DB;
use Moataz\SchemaObjectManager\Contracts\SchemaObject;
use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

class SchemaExecutor
{
    public function apply(SchemaObject $object): void
    {
        match ($object->type()) {
            SchemaObjectType::VIEW => $this->applyView($object),
            default                => $this->recreate($object),
        };
    }

    protected function applyView(SchemaObject $object): void
    {
        DB::unprepared(
            preg_replace('/^CREATE/i', 'CREATE OR REPLACE', $object->definition(), 1)
        );
    }

    protected function recreate(SchemaObject $object): void
    {
        DB::unprepared("DROP {$object->type()->value} IF EXISTS {$object->name()}");
        DB::unprepared($object->definition());
    }
}
