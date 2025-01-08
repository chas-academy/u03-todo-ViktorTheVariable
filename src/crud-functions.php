<?php


require_once 'db.php';

function getUserId($conn, $username) {
    // Hämtar användarens ID från databasen, eller skapar en ny användare om den inte finns
    $stmt = $conn->prepare("SELECT userID FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user) {
        return $user['userID'];
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username) VALUES (?)");
        $stmt->execute([$username]);
        return $conn->lastInsertId();
    }
}

function addGame($conn, $userId, $title, $description) {
    if (!empty($title) && !empty($description)) {
        // Lägger bara in spel om title och description är ifyllda
        $stmt = $conn->prepare("INSERT INTO videoGames (title, description, userID) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $userId]);
    }
}

function getGames($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM videoGames WHERE userID = ? ORDER BY gameID");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

$message = '';

$showList = false; // Variabel som kontrollerar om tabellen ska visas


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_game'])) {
        // Lägger till ett nytt spel
        if (!empty($_POST['username']) && !empty($_POST['title']) && !empty($_POST['description'])) {
            $userId = getUserId($conn, $_POST['username']);
            addGame($conn, $userId, $_POST['title'], $_POST['description']);
            $message = 'Game added successfully';
        }
    }
    elseif (isset($_POST['show_list'])) {
        // visar tabellen
        $showList = true;
    }
}


$currentUsername = isset($_POST['username']) ? $_POST['username'] : '';
$userId = ($currentUsername) ? getUserId($conn, $currentUsername) : 0;
$games = ($userId && !$showList) ? [] : ($userId ? getGames($conn, $userId) : []);

?>