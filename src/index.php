<?php

require_once 'db.php';

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
    <div id="cointainer">
        <header id="header" class="flex input">
            <img src="assets/logo.png" alt="Logo">
            <h1>Video Games</h1>
            <h2>I need to play</h2>
        </header>
        <main id="main" class="flex">
            <h2>Create a list of games</h2>
            <form action="" method="post" class="flex">
                <label for="username" class="label">Type in your username:</label>
                <input type="text" name="username" id="username" class="input"></label>
                <label for="title" class="label">Type in the title of the game:</label>
                <input type="text" name="title" id="title" class="input"></label>
                <label for="description" class="label">Type in a short description of the game:</label>
                <input type="text" name="description" id="description" class="input"></label>
                <input type="submit" value="Create game-task!" class="input">
            </form>
            <button type="button" id="show-lists" class="flex input">Show a list of your game tasks</button>
            <table class="flex">

            </table>
        </main>
        <footer id="footer" class="flex">
            <p>Copyright &copy; Viktor Ekström</p>
        </footer>
    </div>
</body>
</html>