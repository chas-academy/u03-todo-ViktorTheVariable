<?php

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
    <title>Document</title>
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
            <label for="description" class="label">Type in a short description of the game:</label>
            <textarea rows="4" cols="30" name="description" id="description" class="description" maxlength="255"></textarea>
            <input type="submit" name="add_game" value="Add a game to a list" class="input">
            <?php if ($message): ?>
                <p class="input"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <input type='hidden' name='show_list' value='1'>
            <input type='submit' value='Show your list of games!' class='input'>
        </form>
            <?php if ($showList): ?>
                <table class="flex">
                    <caption>My list of games</caption>
                    <?php if (!empty($games)): ?>
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
                            <form method="post" style='display:inline;'>
                                <input type='hidden' name='username' value='<?php echo htmlspecialchars($currentUsername); ?>'>
                                <input type='hidden' name='game_id' value='<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                <input type='hidden' name='toggle_completion'>
                                <input class='buttons toggle-checkbox' type='checkbox' name='is_completed' <?php echo ($game['is_completed']) ? 'checked' : ''; ?>>
                                <input class='buttons save' type='submit' value='Save'>
                            </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" id="toggle-update-form-<?php echo htmlspecialchars($game["gameID"]); ?>" style="display:none;">
                                <label class="buttons change" for="toggle-update-form-<?php echo htmlspecialchars($game["gameID"]); ?>">Change</label>
                                
                                <!-- Update Form -->
                                <div class="update-form" id='update-form-<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                    <form method='post'>
                                        <input type='hidden' name='username' value='<?php echo htmlspecialchars($currentUsername); ?>'>
                                        <input type='hidden' name='game_id' value='<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                        <label for='new_title'>New Title:</label><br>
                                        <input type='text' name='title' required><br>
                                        <label for='new_description'>New Description:</label><br>
                                        <textarea rows="4" cols="30" name="description" class="description" maxlength="255" required></textarea><br>
                                        <input class='buttons update-game' type='submit' name='update_game' value='Update Game'>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr class="space-between">
                            <td colspan="2">
                                <form method="post" style="display: inline;">
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
                    <?php else: ?>
                        <tr><td colspan="2">Add a new game to your list.</td></tr>
                    <?php endif; ?>
                </table>
            <?php endif; ?>
        </main>
        <footer id="footer" class="flex">
            <p>Copyright 2024 &copy; Viktor Ekström</p>
        </footer>
    </div>
</body>
</html>