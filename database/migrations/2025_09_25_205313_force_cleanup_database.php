<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run this migration on MySQL (skip for testing with SQLite)
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Disable foreign key checks to allow dropping tables with dependencies
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $databaseName = DB::getDatabaseName();
        $tableKey = 'Tables_in_' . $databaseName;

        // Define tables we want to KEEP for our portfolio blog
        $keepTables = [
            'migrations',
            'users',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'failed_jobs',
            'sessions',
            'password_reset_tokens',
            'settings',
            'permissions',
            'roles',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'curator',
            'categories',
            'posts',
            'comments',
            'pages',
            'portfolios'
        ];

        // Drop all tables except the ones we want to keep
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            
            if (!in_array($tableName, $keepTables)) {
                try {
                    Schema::dropIfExists($tableName);
                    echo "Dropped table: {$tableName}\n";
                } catch (\Exception $e) {
                    echo "Failed to drop table {$tableName}: " . $e->getMessage() . "\n";
                }
            }
        }

                // Re-enable foreign key checks (only for MySQL)
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as it cleans up existing tables
        // You would need to restore from backup or re-run seeders
    }
};
