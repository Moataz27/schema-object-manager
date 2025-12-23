<?php

namespace Moataz\SchemaObjectManager\Concerns;

trait HasChecksum
{
    final public function checksum(): string
    {
        return hash('sha256', trim($this->definition()));
    }
}
