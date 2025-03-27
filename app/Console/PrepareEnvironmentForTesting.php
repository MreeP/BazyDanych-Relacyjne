<?php

namespace App\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class PrepareEnvironmentForTesting
 *
 * Command to prepare a database for testing
 */
class PrepareEnvironmentForTesting extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:prepare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare database for testing';

    /**
     * @var string
     */
    protected string $connectionName;

    /**
     * @var Connection
     */
    protected Connection $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->connectionName = Config::get('database.test');
        $this->connection = DB::connection($this->connectionName);
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle(): int
    {
        if (Config::get('database.test') === Config::get('database.default')) {
            throw new Exception(__('Database for testing cannot be the same as the default database.'));
        } elseif (Config::get('app.env') === 'production') {
            throw new Exception(__('This command can be run only in the testing / development environment.'));
        }

        $database = Config::get("database.connections.{$this->connectionName}");

        $this->info("Preparing database '{$database['database']}' for testing...");

        try {
            Schema::createDatabase($database['database']);
        } catch (QueryException) {
            //
        }

        Artisan::call('migrate:fresh', [
            '--database' => $this->connectionName,
        ], $this->getOutput());

        $this->info('Database prepared successfully.');

        return 0;
    }

}
