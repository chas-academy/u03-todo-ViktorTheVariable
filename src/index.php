<?php

// Inkluderar nödvändiga filer för databasanslutning och CRUD-operationer
require_once 'db.php';
require_once 'crud-functions.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Viktor Ekström">
        <meta name="description" content="U03-todo">
        <meta name="keywords" content="U03-todo, MariaDB, PDO, Videogames">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Video Games ToDo</title>
        <link type="text/css" rel="stylesheet" href="style/style.css">
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
                    <input type="text" name="username" id="username" class="input" required maxlength="40" value="<?php echo htmlspecialchars($currentUsername); ?>">
                    <label for="title" class="label">Type in the title of the game:</label>
                    <input type="text" name="title" id="title" class="input" maxlength="80">
                    <label for="description" class="label">Type in a game description:</label>
                    <textarea rows="4" cols="30" name="description" id="description" class="description" maxlength="255" pattern="(?!.*\s\s)([^\s]{1,30})(\s[^\s]{1,20})*"></textarea>
                    <input type="submit" name="add_game" value="Add a game to a list" class="input buttons black">
                    <!-- Visar meddelande om en spel har lagts till i listan eller om åtgärd krävs -->
                    <?php if ($message): ?>
                        <p class="input"><?php echo htmlspecialchars($message); ?></p>
                    <?php endif; ?>
                    <input type='hidden' name='show_list' value='1'>
                    <input type='submit' value='Show your list of games!' class='input buttons black'>
                </form>
                <!-- Visar en tabell när $showlist sätts till true via en knapptryckning -->
                <?php if ($showList): ?>
                    <a id="list-start"></a>
                    <table class="flex" id="games-table">
                        <caption>My list of games</caption>
                        <!-- Visar alla spel i en tabell kopplat till en userID -->
                        <?php if (!empty($games)): ?>
                            <!-- skapar tabellelement för varje spel i databasen som finns i arrayen $games -->
                            <?php foreach ($games as $index => $game): ?>
                            <tr>
                                <th>Order of play:</th>
                                <td><?php echo htmlspecialchars($index + 1); ?></td>
                            </tr>
                            <tr>
                                <th>Game title:</th>
                                <td class="game-cells"><?php echo htmlspecialchars($game['title']); ?></td>
                            </tr>
                            <tr>
                                <th>Game description:</th>
                                <td class="game-cells"><?php echo htmlspecialchars($game['description']); ?></td>
                            </tr>
                            <tr>
                                <th>Game finished?:</th>
                                <td>
                                    <!-- omredigerar avnädaren till tabellens början när submit knappen trycks -->
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>#list-start">
                                        <!-- skickar data på ett säkert sätt om vilken användare som gör ändringen -->
                                        <input type='hidden' name='username' value='<?php echo htmlspecialchars($currentUsername); ?>'>
                                        <!-- skickar data på ett-Sahert sätt om i vilket spel som ändringen görs -->
                                        <input type='hidden' name='game_id' value='<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                        <input type='hidden' name='toggle_completion'>
                                        <input class='buttons toggle-checkbox' type='checkbox' name='is_completed' <?php echo ($game['is_completed']) ? 'checked' : ''; ?>>
                                        <input class='buttons save' type='submit' value='Save'>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <!-- Visar eller döljer formuläret till uppdatering av spel efter knapptryckning -->
                                    <input type="checkbox" id="toggle-update-form-<?php echo htmlspecialchars($game["gameID"]); ?>">
                                    <label class="buttons change" for="toggle-update-form-<?php echo htmlspecialchars($game["gameID"]); ?>">Change</label>
                                    
                                    <!-- visar formuläret till uppdatering av rätt spel -->
                                    <div class="update-form" id='update-form-<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                        <form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>#list-start">
                                            <input type='hidden' name='username' value='<?php echo htmlspecialchars($currentUsername); ?>'>
                                            <input type='hidden' name='game_id' value='<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                            <label for='new_title'>New Title:</label><br>
                                            <input type='text' name='new_title' maxlength='80' required><br>
                                            <label for='new_description'>New Description:</label><br>
                                            <textarea rows="4" cols="30" name="new_description" class="description" maxlength="255" required></textarea><br>
                                            <input class='buttons update-game' type='submit' name='update_game' value='Update Game'>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr class="space-between">
                                <td colspan="2">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>#list-start">
                                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($currentUsername); ?>">
                                        <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($game['gameID']); ?>">
                                        <input class='buttons delete' type="submit" name="delete_game" value="Delete">
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <?php endforeach; ?>
                        <!-- Visar meddelande om inga spel finns i listan -->
                        <?php else: ?>
                            <tr><td colspan="2">Add a new game to your list.</td></tr>
                        <?php endif; ?>
                    </table>
                <?php endif; ?>
            </main>
            <footer id="footer" class="flex">
                <p>Copyright 2025 &copy; Viktor Ekström</p>
            </footer>
        </div>
    </body>
</html>