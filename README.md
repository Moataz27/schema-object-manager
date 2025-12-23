# Schema Object Manager

A Laravel package to manage database schema objects (Views, Procedures, Functions, Triggers) as code. This package allows you to version control your database logic and sync it easily across different environments using Artisan commands, similar to how Laravel Migrations manage your tables.

## Features

- **Manage Database Objects**: First-class support for Views, Stored Procedures, Functions, and Triggers.
- **Version Control**: Keep your database logic in your codebase, not hidden in the database.
- **Auto-Discovery**: Automatically finds and registers your schema object classes.
- **Safe Syncing**: Prevents accidental overwrites in production environments (requires `--force`).
- **Artisan Integration**: Simple commands to create and sync your objects.

## Installation

You can install the package via composer:

```bash
composer require moataz/schema-object-manager
```

### Publish Configuration (Optional)

You can publish the configuration file to customize the namespace and other settings:

```bash
php artisan vendor:publish --tag="schema-objects"
```

This will create a `config/schema-objects.php` file where you can configure the namespace for your schema objects and toggle auto-discovery.

## Usage

### Creating Schema Objects

The package provides Artisan commands to generate boilerplate classes for your schema objects. By default, these are created in `App\SchemaObjects`.

**Create a View:**

```bash
php artisan schema:view UserStatsView
```

**Create a Stored Procedure:**

```bash
php artisan schema:procedure CalculatMonthlyRevenue
```

**Create a Function:**

```bash
php artisan schema:function GetUserAge
```

**Create a Trigger:**

```bash
php artisan schema:trigger BeforeUserUpdate
```

### Defining Your Object

Once created, you can define the logic in the generated class. Here is an example of a View:

```php
<?php

namespace App\SchemaObjects;

use Moataz\SchemaObjectManager\Objects\View;

class UserStatsView extends View
{
    /**
     * Get the name of the schema object.
     */
    public function name(): string
    {
        return 'user_stats_view';
    }

    /**
     * Get the SQL definition of the schema object.
     */
    public function definition(): string
    {
        return <<<'SQL'
        CREATE VIEW user_stats_view AS
        SELECT
            users.id,
            users.name,
            COUNT(orders.id) as total_orders
        FROM users
        LEFT JOIN orders ON orders.user_id = users.id
        GROUP BY users.id
        SQL;
    }
}
```

### Syncing to Database

To apply your changes to the database, run the sync command:

```bash
php artisan schema:sync
```

This command will iterate through all discoverable schema objects and execute their definitions against the database.

**Production Safety:**
If you run this command in a production environment, it will fail by default to prevent accidental changes. To force the sync in production, use the `--force` flag:

```bash
php artisan schema:sync --force
```

## Configuration

The `config/schema-objects.php` file allows you to configure:

- **objects**: Manually register object classes if auto-discovery is disabled.
- **namespace**: The default namespace where new objects are created (default: `App\SchemaObjects`).
- **cache**: Configuration for caching discovered objects to improve performance.
- **auto_discover**: Enable or disable automatic discovery of schema objects in the configured namespace.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
