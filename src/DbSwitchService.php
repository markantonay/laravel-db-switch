<?php
namespace Rolice\LaravelDbSwitch;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\MySqlConnection;

/**
 * The service class itself registered by the service provider inside Laravel/Lumen application.
 * @name DbSwitchService
 * @package LaravelDbSwitch
 * @author Lyubomir Gardev <l.gardev@intellisys.org>
 * @version 1.0
 */
class DbSwitchService
{
    /**
     * Function which changes directly the default connection DB transparently for the database and models instances.
     * @param string $database The database to switch to.
     */
    public function to($database)
    {
        Config::set('database.default', $database);
    }

    /**
     * Method that changes specific, custom connection database with another.
     * @param string $key The unified key under which you sill switch dynamically databases, ex. platform, site, etc.
     * @param string $database The database to switch to.
     */
    public function connectionTo($key, $database)
    {
        Config::set("database.connections.{$key}", $database);

        $this->reconnect($key, $database);
    }

    /**
     * Changes platform active connection database name and reconnect to it.
     * @param string $key The connection key under which you will switch databases, ex. platform, site, etc.
     * @param string $database The database to reconnect to.
     */
    protected function reconnect($key)
    {
        DB::purge('mysql');
        // Switch in set default;
        DB::setDefaultConnection($key);
        DB::reconnect();
    }

}
