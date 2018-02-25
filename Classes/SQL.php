<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'littlewargame');
define('DB_USER', 'littlewargame');
define('DB_PASS', 'littlewargame');
define('DB_CHAR', 'utf8');

class SQL
{
    private static $_SQL = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if(self::$_SQL == null)
            self::$_SQL = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHAR, DB_USER, DB_PASS);

        return self::$_SQL;
    }
}
?>