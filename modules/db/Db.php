<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 22.08.13
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */
namespace db;

class Db
{
    const DSN = 'mysql:dbname=money;host=127.0.0.1';
    const USER = 'root';
    const PASS = '';

    protected static $dbh;
    private static $instance = null;

    public static function getConnection()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$dbh;
    }

    private function __clone()
    {

    }

    private function __construct()
    {
        try {
            self::$dbh = new \PDO(self::DSN, self::USER, self::PASS);
        } catch (\PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }
}