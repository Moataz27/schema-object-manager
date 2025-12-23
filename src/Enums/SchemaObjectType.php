<?php

namespace Moataz\SchemaObjectManager\Enums;

use BenSampo\Enum\Enum;

class SchemaObjectType extends Enum
{
    const VIEW      = 'view';
    const PROCEDURE = 'procedure';
    const FUNCTION  = 'function';
    const TRIGGER   = 'trigger';
}
