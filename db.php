<?php
function getDBConnection() {
    $servername = "sql12.freesqldatabase.com";
    $username = "sql12778486";
    $password = "lULgmXJ8Wj";
    $database = "sql12778486";
    $port = 3306;

    // Include port in mysqli connection
    $connection = new mysqli($servername, $username, $password, $database, $port);

    if ($connection->connect_error) {
        die("Error: Failed to connect to MySQL. " . $connection->connect_error);
    }

    return $connection;
}
?>
