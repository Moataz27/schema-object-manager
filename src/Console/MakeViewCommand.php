<?php

namespace Moataz\SchemaObjectManager\Console;

use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

class MakeViewCommand extends SchemaObjectCommand
{
    protected $signature = 'schema:view {name} {--path= : The path relative to the main namespace where the view will be created}';

    protected $description = 'Create a new view';

    public function type(): SchemaObjectType
    {
        return SchemaObjectType::fromValue(SchemaObjectType::VIEW);
    }
}
