<?php
class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) 
        {
            $host = getenv('MYSQLHOST');

            if ($host !== false) 
            {
                $port = getenv('MYSQLPORT') ?: '3306';
                $dbname = getenv('MYSQLDATABASE');
                $user = getenv('MYSQLUSER');
                $pass = getenv('MYSQLPASSWORD');
            } 
            else 
            {
                $config = require '../app/config/database.php';
                $host = $config['host'];
                $port = $config['port'] ?? '3306';
                $dbname = $config['dbname'];
                $user = $config['user'];
                $pass = $config['pass'];
            }

            self::$connection = new PDO(
                "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
                $user,
                $pass
            );

            self::$connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }
}