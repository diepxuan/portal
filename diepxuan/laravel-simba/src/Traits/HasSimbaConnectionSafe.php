<?php

namespace Diepxuan\Simba\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use PDOException;

/**
 * Trait HasSimbaConnectionSafe
 * 
 * Safe version with fallback to default connection if sqlsrv not available.
 * 
 * @package Diepxuan\Simba\Traits
 */
trait HasSimbaConnectionSafe
{
    /**
     * Get the Simba database connection name with fallback.
     *
     * @return string
     */
    public function getSimbaConnectionName(): string
    {
        $connection = Config::get('simba.connection', 'sqlsrv');
        
        // Check if sqlsrv driver is available
        if ($connection === 'sqlsrv') {
            try {
                // Try to get PDO driver list
                $drivers = \PDO::getAvailableDrivers();
                if (!in_array('sqlsrv', $drivers)) {
                    // Fallback to default connection
                    return Config::get('database.default', 'mysql');
                }
            } catch (\Exception $e) {
                // Fallback to default connection
                return Config::get('database.default', 'mysql');
            }
        }
        
        return $connection;
    }

    /**
     * Get the Simba database connection instance with safe fallback.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getSimbaConnection()
    {
        $connectionName = $this->getSimbaConnectionName();
        
        try {
            return DB::connection($connectionName);
        } catch (PDOException $e) {
            // If sqlsrv driver not found, fallback to default
            if (str_contains($e->getMessage(), 'could not find driver')) {
                return DB::connection(Config::get('database.default', 'mysql'));
            }
            throw $e;
        }
    }

    /**
     * Check if Simba connection is available.
     *
     * @return bool
     */
    public function isSimbaConnectionAvailable(): bool
    {
        try {
            $this->getSimbaConnection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
