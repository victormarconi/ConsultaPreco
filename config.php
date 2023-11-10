<?php

// Detectando o sistema operacional e definindo o caminho do MySQL de acordo
$mysqlDir = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'C:/xampp/mysql/bin/mysql.exe' : '/usr/bin/mysql';

$config = array (
    'dbhost' => '0.0.0.0',
    'dbuser' => 'root',
    'dbpass' => 'senha',
    'dbname' => 'nomebanco',
    'filialid' => '1',
    'sqlFile' => 'command.sql',
    'mysqlDir' => $mysqlDir,
);

?>
