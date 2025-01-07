<?php

session_start(); // Starta sessionen
require_once 'db.php';

function saveUsernameToSession($username) {
    $_SESSION['username'] = $username;
}

function getUsernameFromSession() {
    return $_SESSION['username'] ?? '';
}

function insertUserGameAndList($conn, $username, $gameTitle, $gameDescription) {
    $conn->beginTransaction();

    try {
        $stmt = $conn->prepare("SELECT userID FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $userId = $stmt->fetchColumn();

        if (!$userId) {
            $stmt = $conn->prepare("INSERT INTO users (username) VALUES (:username)");
            $stmt->execute([':username' => $username]);
            $userId = $conn->lastInsertId();
        }

        $stmt = $conn->prepare("SELECT listID FROM lists WHERE userID = :userId");
        $stmt->execute([':userId' => $userId]);
        $listId = $stmt->fetchColumn();

        if (!$listId) {
            $title = "My list of games";
            $stmt = $conn->prepare("INSERT INTO lists (userID, title) VALUES (:userId, :title)");
            $stmt->execute([':userId' => $userId, ':title' => $title]);
            $listId = $conn->lastInsertId();
        }

        $stmt = $conn->prepare("INSERT INTO videoGames (listID, title, description) VALUES (:listId, :title, :description)");
        $stmt->execute([
            ':listId' => $listId,
            ':title' => $gameTitle,
            ':description' => $gameDescription
        ]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        echo "Fel: " . htmlspecialchars($e->getMessage());
        $conn->rollBack();
        return false;
    }
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'], $_POST['description'])) {
    $username = $_POST['username'];
    $gameTitle = $_POST['title'];
    $gameDescription = $_POST['description'];

    if (insertUserGameAndList($conn, $username, $gameTitle, $gameDescription)) {
        $message = "Your game has been added to your list.";
    } else {
        $message = "An error occurred. Please try again.";
    }
}


function createGameListTable($conn, $userId) {
    $sql = "SELECT videoGames.gameID, videoGames.title, videoGames.description, videoGames.is_completed
            FROM videoGames
            JOIN lists l ON videoGames.listID = l.listID
            WHERE l.userID = :userId
            ORDER BY videoGames.gameID";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([':userId' => $userId]);
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tableHtml = "<table border='1'>";
    
    foreach ($games as $index => $game) {
        $orderNumber = $index + 1; // Skapar ett ordningsnummer som börjar på 1
        $tableHtml .= "<tr>
                        <td>Order of play</td>
                        <td>{$orderNumber}</td>
                       </tr>
                       <tr>
                        <td>Game title</td>
                        <td>{$game['title']}</td>
                       </tr>
                       <tr>
                        <td>Game description</td>
                        <td>{$game['description']}</td>
                       </tr>
                       <tr>
                        <td>Game finished?</td>
                        <td>
                            <form method='post' action='index.php'>
                                <input type='hidden' name='gameID' value='{$game['gameID']}'>
                                <input type='checkbox' name='is_completed' " . ($game['is_completed'] ? 'checked' : '') . " onchange='this.form.submit()'>
                            </form>
                        </td>
                       </tr>
                       <tr>
                        <td><button class='change-game' data-gameid='{$game['gameID']}'>Change</button></td>
                        <td><button class='delete-game' data-gameid='{$game['gameID']}'>Delete</button></td>
                       </tr>";
        
        // Lägg till en tom rad mellan spelen för bättre läsbarhet
        if ($index < count($games) - 1) {
            $tableHtml .= "<tr><td colspan='2'>&nbsp;</td></tr>";
        }
    }
    
    $tableHtml .= "</table>";
    
    return $tableHtml;
}

// Hantera visning av spellista
$tableHtml = '';
if (isset($_POST['showGames'])) {
    // Hämta userID baserat på username
    $username = $_POST['username']; // Användarnamn från formuläret
    $stmt = $conn->prepare("SELECT userID FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $userId = $stmt->fetchColumn();

    if ($userId) {
        // Anropa funktionen för att skapa tabellen om användaren finns
        $tableHtml = createGameListTable($conn, $userId);
    } else {
        $message2 = "User not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gameID'])) {
    $gameId = $_POST['gameID'];
    $isCompleted = isset($_POST['is_completed']) ? 1 : 0; // 1 för klar, 0 för inte klar

    try {
        $stmt = $conn->prepare("UPDATE videoGames SET is_completed = :isCompleted WHERE gameID = :gameId");
        $stmt->execute([':isCompleted' => $isCompleted, ':gameId' => $gameId]);
        
        // Om du vill ge en bekräftelse kan du sätta ett meddelande här
        $message = "Game status updated successfully.";
    } catch (Exception $e) {
        echo "Fel: " . htmlspecialchars($e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    saveUsernameToSession($_POST['username']);
}


?>