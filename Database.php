<?php
declare(strict_types=1);
class Database{

    private static ?PDO $instance = null;

    public static function getConnection(): PDO{
        if (self::$instance === null){
            self::$instance = new PDO(
                dsn: "pgsql:host=localhost;port=5432;dbname=phpbanco", //getenv('DSN'),
                username: "postgres", //getenv('USERNAME'),
                password: "postgres", //getenv('PASSWORD'),
                options: [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_STRINGIFY_FETCHES => false,
                ]

            );
        }
        return self::$instance;
    }

}