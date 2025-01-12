<?php

// Inkluderar databaskopplingen
require_once 'db.php';

// Funktion för att hämta användarens ID baserat på användarnamn
function getUserId(PDO $pdo, string $username): int
{
    // Förbereder SQL-frågan för att hämta userID från users-tabellen
    $stmt = $pdo->prepare('SELECT userID FROM users WHERE username = :username');
    // Binder parametern :username till variabeln $username
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    // Utför frågan
    $stmt->execute();
    // Hämtar resultatet
    $user = $stmt->fetch();

    // Om användaren finns, returnera deras userID
    if ($user) {
        return (int) $user['userID'];
    } else {
        // Om användaren inte finns, lägg till dem i databasen
        $stmt = $pdo->prepare('INSERT INTO users (username) VALUES (:username)');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        // Returnerar det senaste insatta ID:t
        return (int) $pdo->lastInsertId();
    }
}

// Funktion för att lägga till ett spel i databasen
function addGame(PDO $pdo, int $userId, string $title, string $description): void
{
    // Förbereder SQL-frågan för att lägga till ett nytt spel
    $stmt = $pdo->prepare(
        'INSERT INTO videoGames (title, description, userID) ' .
        'VALUES (:title, :description, :userId)'
    );
        // Binder parametrarna till variablerna
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

// Funktion för att hämta alla spel för en specifik användare
function getGames(PDO $pdo, int $userId): array
{
    // Förbereder SQL-frågan för att hämta spel baserat på userID
    $stmt = $pdo->prepare('SELECT * FROM videoGames WHERE userID = :userId ORDER BY gameID');
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Funktion för att ändra statusen på ett spel (komplett/inte komplett)
function toggleCheckbox(PDO $pdo, int $gameId, bool $isCompleted): void
{
    // Förbereder SQL-frågan för att uppdatera is_completed-fältet i videoGames-tabellen
    $stmt = $pdo->prepare('UPDATE videoGames SET is_completed = :isCompleted WHERE gameID = :gameId');
    $stmt->bindParam(':isCompleted', $isCompleted, PDO::PARAM_BOOL);
    $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
    $stmt->execute();
}

// Funktion för att uppdatera ett spels information (titel, beskrivning och status)
function updateGames(PDO $pdo, int $gameId, string $title, string $description, bool $isCompleted): void
{
    // Förbereder SQL-frågan för att uppdatera spelets information
    $stmt = $pdo->prepare(
        'UPDATE videoGames SET title = :title, description = :description, ' .
        'is_completed = :isCompleted WHERE gameID = :gameId'
    );
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':isCompleted', $isCompleted, PDO::PARAM_BOOL);
    $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
    $stmt->execute();
}

// Funktion för att radera ett spel från databasen
function deleteGame(PDO $pdo, int $gameId): void
{
    // Förbereder SQL-frågan för att radera ett spel baserat på gameID
    $stmt = $pdo->prepare('DELETE FROM videoGames WHERE gameID = :gameId');
    $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
    $stmt->execute();
}

$message = '';  // Variabel för meddelanden som ska visas till användaren
$showList = false;  // Variabel som kontrollerar om tabellen med spel ska visas

// Kontrollerar om en POST-förfrågan har skickats från något formulär
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kontrollerar om knappen add_game har skickats via POST
    if (isset($_POST['add_game'])) {
        // Lägger till spel om formuläret har skickats genom 'add_game' knappen
        if (!empty($_POST['username']) && !empty($_POST['title']) && !empty($_POST['description'])) {
            // Hämtar användarens ID
            $userId = getUserId($conn, $_POST['username']);
            // Lägger till spelet i databasen genom funktionen
            addGame($conn, $userId, $_POST['title'], $_POST['description']);
            // Sparar användarnamnet från formuläret i sessionen så att det kan användas senare
            $_SESSION['currentUsername'] = $_POST['username'];
            // Omdirigerar användaren tillbaka till samma sida för att förhindra dubbelt inlägg av spel
            header("Location: " . $_SERVER['PHP_SELF']);
            // Avslutar scriptet för att säkerställa att ingen ytterligare kod körs efter omdirigeringen
            exit();
        } else {
            $_SESSION['currentUsername'] = $_POST['username'];
            // Meddelande om att fälten måste fyllas i korrekt
            $message = 'Please fill in both title and description fields';
        }
        
    } elseif (isset($_POST['toggle_completion'])) {
        // Kontrollerar om checkboxen är markerad eller inte och sätter statusen därefter
        $isCompleted = isset($_POST['is_completed']);
        // Uppdaterar statusen i databasen genom att kalla funktionen
        toggleCheckbox($conn, (int) $_POST['game_id'], $isCompleted);
        // Sätter showList till true för att visa tabellen efter uppdatering
        $showList = true;

    } elseif (isset($_POST['update_game'])) {
        // Uppdatera spelinformation om formuläret har skickats genom 'update_game' knappen
        updateGames(
            $conn,
            (int) $_POST['game_id'],
            $_POST['new_title'],
            $_POST['new_description'],
            isset($_POST['is_completed'])
        );
        $showList = true;

    } elseif (isset($_POST['delete_game'])) {
        // Radera spel om formuläret har skickats genom 'delete_game' knappen
        deleteGame($conn, (int) $_POST['game_id']); 
        $showList = true;

    } elseif (isset($_POST['show_list'])) {
        // Visa tabellen om formuläret har skickats genom 'show_list' inputfältet via en knapptryckning
        $showList = true;
    }
}

// Sätter $currentUsername till sessionens namn om det finns, annars till användarens inmatning i formuläret.
$currentUsername = isset($_SESSION['currentUsername']) ? $_SESSION['currentUsername'] 
    : (isset($_POST['username']) ? $_POST['username'] : '');
// Hämtar användarens ID om $currentUsername är angivet; annars sätts $userId till 0.
$userId = ($currentUsername) ? getUserId($conn, $currentUsername) : 0;
// Om $userId är giltigt och listan inte visas, returneras en tom lista; annars hämtas användarens spel.
$games = ($userId && !$showList) ? [] : ($userId ? getGames($conn, $userId) : []);

