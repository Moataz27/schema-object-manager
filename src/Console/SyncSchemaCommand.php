<?php

namespace Moataz\SchemaObjectManager\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Moataz\SchemaObjectManager\SchemaManager;

class SyncSchemaCommand extends Command
{
    protected $signature = 'schema:sync {--force : Force sync even if the application is in production}';

    protected $description = 'Sync schema objects';

    public function handle(SchemaManager $manager)
    {
        if ($this->option('force') && App::isProduction()) {
            $this->warn('Warning: Syncing schema objects in production is not recommended! Use --force to override.');
            return Command::FAILURE;
        }

        foreach ($manager->sync() as $message) {
            $this->info($message);
        }
    }
}
