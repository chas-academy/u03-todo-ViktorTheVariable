<?php

require_once 'db.php';
require_once 'crud-functions.php';

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
                                    <input type='checkbox'name='is_completed'>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <form method="post" style="display: inline;">
                                <input type="submit" name="delete_game" value="Delete">
                            </form>
                            </td>
                            <td>
                            <form method="post" style="display: inline;">
                                <input type="submit" name="update_game" value="Update">
                            </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
            <!-- Message when there are no games -->
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