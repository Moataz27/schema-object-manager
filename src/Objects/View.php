<?php

namespace Moataz\SchemaObjectManager\Objects;

use Moataz\SchemaObjectManager\Concerns\HasChecksum;
use Moataz\SchemaObjectManager\Contracts\SchemaObject;
use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

abstract class View implements SchemaObject
{
    use HasChecksum;

    abstract public function name(): string;

    abstract public function definition(): string;

    final public function type(): SchemaObjectType
    {
        return SchemaObjectType::fromValue(SchemaObjectType::VIEW);
    }
}
