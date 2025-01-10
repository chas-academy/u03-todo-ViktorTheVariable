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


function updateGame($pdo, $gameId, $title, $description, $isCompleted) {
    if ($title !== null && $description !== null) {
        // Om title och description inte är null, uppdatera dem
        $stmt = $pdo->prepare("UPDATE videoGames SET title = ?, description = ?, is_completed = ? WHERE gameID = ?");
        $stmt->execute([$title, $description, $isCompleted, $gameId]);
    } else {
        // Om title eller description inte finns, uppdatera bara is_completed
        $stmt = $pdo->prepare("UPDATE videoGames SET is_completed = ? WHERE gameID = ?");
        $stmt->execute([$isCompleted, $gameId]);
    }
}

function deleteGame($conn, $gameId) {
    // Radera spel
    $stmt = $conn->prepare("DELETE FROM videoGames WHERE gameID = ?");
    $stmt->execute([$gameId]);
}


$message = '';

$showList = false; // Variabel som kontrollerar om tabellen ska visas


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_game'])) {
        // Lägger till spel
        if (!empty($_POST['username']) && !empty($_POST['title']) && !empty($_POST['description'])) {
            $userId = getUserId($conn, $_POST['username']);
            addGame($conn, $userId, $_POST['title'], $_POST['description']);
            $message = 'Game added successfully';
        }
        else {
            $message = 'Please fill in both title and description fields';
        }
    }
    elseif (isset($_POST['toggle_completion'])) {
    // Ändra spelstatus
    $isCompleted = isset($_POST['is_completed']) ? 1 : 0;
    updateGame($conn, $_POST['game_id'], null, null, $isCompleted);
    $showList = true; // visa tabellen efter uppdatering
    }    
    elseif (isset($_POST['update_game'])) {
    // Uppdatera spel
    updateGame($conn, $_POST['game_id'], $_POST['title'], $_POST['description'], isset($_POST['is_completed']) ? 1 : 0);
    $showList = true; // visa tabellen efter uppdatering
    }   
    elseif (isset($_POST['delete_game'])) {
    // Radera spel
    deleteGame($conn, $_POST['game_id']);
    $showList = true; // visa tabellen efter radering
    }
    elseif (isset($_POST['show_list'])) {
    $showList = true; // visa tabellen
    }
}


$currentUsername = isset($_POST['username']) ? $_POST['username'] : '';
$userId = ($currentUsername) ? getUserId($conn, $currentUsername) : 0;
$games = ($userId && !$showList) ? [] : ($userId ? getGames($conn, $userId) : []);

?>