<?php


require_once 'crud-functions.php';

// Hämta användarnamn från sessionen
$username = getUsernameFromSession();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div id="container">
        <header id="header" class="flex input">
            <img src="assets/logo.png" alt="Logo">
            <h1>Video Games</h1>
            <h2>I need to play</h2>
        </header>
        <main id="main" class="flex">
            <h2>Create a list of games</h2>
            <form method="post" class="flex">
                <label for="username" class="label">Type in your username:</label>
                <input type="text" name="username" id="username" class="input" required>
                <label for="title" class="label">Type in the title of the game:</label>
                <input type="text" name="title" id="title" class="input" required>
                <label for="description" class="label">Type in a short description of the game:</label>
                <textarea type="text" name="description" id="description" class="input" required></textarea>
                <input type="submit" value="Add a game to a list" class="input">
            </form>

            <?php if ($message): ?>
                <p class="input"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <!-- Formulär för att visa spellistan -->
            <form method="post">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <input type="submit" name="showGames" value="Show your list of games!" class="input">
            </form>

            <?php if ($tableHtml): ?>
                <div id="gameTableContainer">
                    <?php echo $tableHtml; ?>
                </div>
            <?php endif; ?>

        </main>
        <footer id="footer" class="flex">
            <p>Copyright &copy; Viktor Ekström</p>
        </footer>
    </div>
</body>
</html>