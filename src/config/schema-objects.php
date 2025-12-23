<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Schema Objects
    |--------------------------------------------------------------------------
    |
    | List all schema objects (views, procedures, functions, triggers)
    | These classes must implement SchemaObject.
    |
    */
    'objects' => [],

    /**
     * The namespace of the schema objects.
     */
    'namespace' => 'App\\SchemaObjects',

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'key' => 'schema_objects.discovered',
    ],

    /**
     * Whether to automatically discover schema objects.
     */
    'auto_discover' => true,
];
