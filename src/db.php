<?php

// Definierar servernamnet för databasen (i detta fall en MariaDB-server)
$servername = "mariadb";
// Anger användarnamnet för att ansluta till databasen
$username = "root";
// Anger lösenordet för databasanvändaren
$password = "v.E";
// Anger namnet på databasen som ska användas
$database = "U03-todo";

try {
    // Skapar en ny PDO-instans för att ansluta till databasen med angivna parametrar
    $conn = new PDO(
        "mysql:host=$servername;dbname=$database",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );

    // Meddelande som visas om anslutningen till databasen lyckas
    // echo "Anslutning lyckades!"; tog bort för att sidan skulle bli lite snyggare
} catch (PDOException $e) {
    // Fångar eventuella undantag som kastas vid anslutningsfel
    echo "Anslutningsfel: " . $e->getMessage(); // Visar ett felmeddelande om anslutningen misslyckas
}


?>