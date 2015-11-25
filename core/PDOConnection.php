<?php

//file; /core/PDOConnection
class PDOConnection
{
    private static $dbhost = "127.0.0.1";
    private static $dbname = "grupo13";
    private static $dbuser = "adminG13";
    private static $dbpass = "abc123.";
    private static $db_singleton = null;

    public static function getInstance()
    {
        if (self::$db_singleton == null) {
            self::$db_singleton = new PDO(
                "mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname . ";charset=utf8", // connection string
                self::$dbuser,
                self::$dbpass,
                array( // options
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        return self::$db_singleton;
    }
}