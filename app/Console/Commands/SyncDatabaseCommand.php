<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SyncDatabaseCommand extends Command
{
    protected $signature = 'sync:database';
    protected $description = 'Sync local MySQL data to remote Supabase PostgreSQL';

    public function handle()
    {
        // Set up the pgsql connection dynamically
        Config::set('database.connections.supabase', [
            'driver' => 'pgsql',
            'url' => null,
            'host' => 'aws-1-ap-south-1.pooler.supabase.com',
            'port' => '6543',
            'database' => 'postgres',
            'username' => 'postgres.nfwleyjxbkcwijqsxqsv',
            'password' => 'DICKY123aldian@',
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);

        $tables = [
            'users',
            'settings',
            'sliders',
            'beritas',
            'perangkats',
            'potensis',
            'lembagas',
            'layanans',
            'pengaduans'
        ];

        foreach ($tables as $table) {
            $this->info("Syncing table: {$table}");
            
            // Delete existing data in Supabase (optional, but good for exact sync)
            DB::connection('supabase')->table($table)->delete();

            // Get local data
            $localData = DB::connection('mysql')->table($table)->get()->map(function($item) {
                return (array) $item;
            })->toArray();

            if (count($localData) > 0) {
                // Insert into supabase in chunks
                foreach (array_chunk($localData, 50) as $chunk) {
                    DB::connection('supabase')->table($table)->insert($chunk);
                }
                $this->info("Synced " . count($localData) . " rows for {$table}");
            } else {
                $this->info("No data to sync for {$table}");
            }
        }

        $this->info('Database sync completed successfully!');
    }
}
