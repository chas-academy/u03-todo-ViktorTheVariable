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
    <style>
        input[type="checkbox"]:checked + label + div {
        display: block;
        }
        div.update-form {
            display: none;
        }
    </style>
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
            <input type="text" name="username" id="username" class="input" required value="<?php echo htmlspecialchars($currentUsername); ?>">
            <label for="title" class="label">Type in the title of the game:</label>
            <input type="text" name="title" id="title" class="input">
            <label for="description" class="label">Type in a short description of the game:</label>
            <input type="text" name="description" id="description">
            <input type="submit" name="add_game" value="Add a game to a list" class="input">
            <input type='hidden' name='show_list' value='1'>
            <input type='submit' value='Show your list of games!' class='input'>
        </form>
            <?php if ($message): ?>
                <p class="input"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
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
                            <td><?php echo htmlspecialchars($game['title']); ?></td>
                        </tr>
                        <tr>
                            <th>Game description:</th>
                            <td><?php echo htmlspecialchars($game['description']); ?></td>
                        </tr>
                        <tr>
                            <th>Game finished?:</th>
                            <td>
                            <form method="post" style='display:inline;'>
                                <input type='hidden' name='username' value='<?php echo htmlspecialchars($currentUsername); ?>'>
                                <input type='hidden' name='game_id' value='<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                <input type='hidden' name='toggle_completion'>
                                <input type='checkbox' name='is_completed' <?php echo ($game['is_completed']) ? 'checked' : ''; ?>>
                                <input type='submit' value='Save'>
                            </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" id="toggle-update-form-<?php echo htmlspecialchars($game["gameID"]); ?>" style="display:none;">
                                <label for="toggle-update-form-<?php echo htmlspecialchars($game["gameID"]); ?>" style="cursor:pointer;">Update</label>
                                
                                <!-- Update Form -->
                                <div class="update-form" id='update-form-<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                    <form method='post'>
                                        <input type='hidden' name='username' value='<?php echo htmlspecialchars($currentUsername); ?>'>
                                        <input type='hidden' name='game_id' value='<?php echo htmlspecialchars($game["gameID"]); ?>'>
                                        <label for='new_title'>New Title:</label><br>
                                        <input type='text' name='title' required><br>
                                        <label for='new_description'>New Description:</label><br>
                                        <input type='text' name='description' required><br>
                                        <input type='submit' name='update_game' value='Update Game'>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No games found.</td></tr>
                    <?php endif; ?>
                </table>
            <?php endif; ?>
        </main>
        <footer id="footer" class="flex">
            <p>Copyright &copy; Viktor Ekström</p>
        </footer>
    </div>
</body>
</html>