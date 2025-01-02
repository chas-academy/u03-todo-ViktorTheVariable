CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(40) NOT NULL UNIQUE
);

CREATE TABLE lists (
    listID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES users(userID)
);

CREATE TABLE videoGames (
    gameID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(80) NOT NULL,
    description VARCHAR(255),
    is_completed BOOLEAN DEFAULT FALSE,
    listID INT NOT NULL,
    FOREIGN KEY (listID) REFERENCES lists(listID)
);