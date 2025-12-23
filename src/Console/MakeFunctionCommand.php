<?php

namespace Moataz\SchemaObjectManager\Console;

use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

class MakeFunctionCommand extends SchemaObjectCommand
{
    protected $signature = 'schema:function {name} {--path= : The path relative to the main namespace where the function will be created}';

    protected $description = 'Create a new function';

    public function type(): SchemaObjectType
    {
        return SchemaObjectType::fromValue(SchemaObjectType::FUNCTION);
    }
}
