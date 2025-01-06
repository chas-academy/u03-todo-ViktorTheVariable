<?php

require_once 'db.php';

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $gameTitle = $_POST['title'];
    $gameDescription = $_POST['description'];

    if (insertUserGameAndList($conn, $username, $gameTitle, $gameDescription)) {
        $message = "Your game has been added to your list.";
    } else {
        $message = "An error occurred. Please try again.";
    }
}

?>