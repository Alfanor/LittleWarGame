<?php
 if(long2ip(ip2long($_SERVER['REMOTE_ADDR'])) == '127.0.0.1') {
    $dsn = 'mysql:dbname=littlewargame;host=127.0.0.1';
    $user = 'littlewargame';
    $password = 'littlewargame';
}

else {
    $dsn = 'mysql:dbname=littlewargame;host=127.0.0.1';
    $user = 'littlewargame';
    $password = 'littlewargame';
}

$_SQL = new PDO($dsn, $user, $password);

$_SQL->exec("SET CHARACTER SET utf8");
?>