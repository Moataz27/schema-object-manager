<?php

namespace Moataz\SchemaObjectManager\Contracts;

use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

interface SchemaObject
{
    public function name(): string;
    public function type(): SchemaObjectType;
    public function definition(): string;
}
