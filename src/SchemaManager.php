<?php

namespace Moataz\SchemaObjectManager;

use Generator;
use Moataz\SchemaObjectManager\Engine\SchemaExecutor;
use Moataz\SchemaObjectManager\Discovery\SchemaObjectFinder;

class SchemaManager
{
    public function __construct(
        protected SchemaObjectFinder $finder,
        protected SchemaExecutor $executor,
    ) {}

    public function sync(): Generator
    {
        foreach ($this->finder->discover() as $object) {
            $this->executor->apply($object);
            yield ucfirst($object->type()) . " {$object->name()} synced successfully!";
        }
    }
}
