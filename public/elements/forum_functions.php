<?php

function connectDatabase()
{
    $serverName = 'localhost';
    $dbName = 'dev_forum';
    $username = 'root';
    $password = '';

    // Start DB connection
    $conn = new \PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);

    return $conn;
}
