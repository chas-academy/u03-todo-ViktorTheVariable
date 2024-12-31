<?php

$servername = "mariadb";
$username = "root";
$password = "v.E";
$database = "U03-todo";


try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$database", 
        "root", 
        "v.E", 
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "Anslutning lyckades!";
} catch (PDOException $e) {
    echo "Anslutningsfel: " . $e->getMessage();
}

?>