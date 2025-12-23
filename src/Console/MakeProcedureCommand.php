<?php

namespace Moataz\SchemaObjectManager\Console;

use Moataz\SchemaObjectManager\Enums\SchemaObjectType;

class MakeProcedureCommand extends SchemaObjectCommand
{
    protected $signature = 'schema:procedure {name} {--path= : The path relative to the main namespace where the procedure will be created}';

    protected $description = 'Create a new procedure';

    public function type(): SchemaObjectType
    {
        return SchemaObjectType::fromValue(SchemaObjectType::PROCEDURE);
    }
}
