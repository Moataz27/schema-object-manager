<?php

namespace Moataz\SchemaObjectManager\Console;

use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

class MakeTriggerCommand extends SchemaObjectCommand
{
    protected $signature = 'schema:trigger {name} {--path= : The path relative to the main namespace where the trigger will be created}';

    protected $description = 'Create a new trigger';

    public function type(): SchemaObjectType
    {
        return SchemaObjectType::fromValue(SchemaObjectType::TRIGGER);
    }
}
