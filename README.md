# U03-todo

[Länk till ER-Diagram](https://www.figma.com/design/oGqJhH8jCxsHc1e2w2Qg6W/U03-ERDiagram-FigmaSkiss?node-id=0-1&p=f&t=LLaNUQibLpP9yzGb-0)

[Länk till figma-skiss](https://www.figma.com/design/oGqJhH8jCxsHc1e2w2Qg6W/U03-ERDiagram-FigmaSkiss?node-id=0-1&p=f&t=LLaNUQibLpP9yzGb-0)

## Instruktioner
1. Krav
Innan du börjar, se till att du har följande installerat på din dator:
Docker (version 20.10 eller högre)
Docker Compose (version 1.27 eller högre)
2. Klona eller ladda ner koden
Klona eller ladda ner källkoden från [repository-länk] (om tillgänglig) och extrahera den till en mapp på din dator.
3. Strukturera projektet
Se till att din mappstruktur ser ut som följande:
text
/project-root
│
├── src
│   ├── index.php
│   ├── db.php
│   ├── crud-functions.php
│   ├── style
│   │   └── style.css
│   ├── assets
│   │   └── logo.png
│   └── seed
│       └── sql-seed.sql
│
├── Dockerfile
└── docker-compose.yml
4. Bygg och starta containrarna
Navigera till projektets rotmapp där docker-compose.yml finns och kör följande kommando:
bash
docker-compose up
Detta kommando kommer att:
Bygga PHP-applikationen med Apache.
Starta en MariaDB-databas.
Starta Adminer för databasadministration.
5. Åtkomst till applikationen
Öppna din webbläsare och navigera till http://localhost för att komma åt applikationen.
6. Åtkomst till Adminer (databasadministration)
För att hantera databasen kan du använda Adminer. Öppna din webbläsare och navigera till http://localhost:8080. Logga in med följande uppgifter:
Server: mariadb
Användarnamn: root
Lösenord: v.E
Databas: U03-todo
7. Använd applikationen
Fyll i användarnamn, spel titel och beskrivning i formuläret.
Klicka på "Add a game to a list" för att lägga till spelet i din lista.
Klicka på "Show your list of games" för att visa listan.
Du klickar i checkboxen till höger om game finished kolumnen i listan och trycker sedan på "save" knappen för att spara statusen. Du uppdaterar ett spels title och beskrivning i listan genom att klicka "change" knappen och skriver in den nya datan i dom båda formulären och sedan klicka på "update game" knappen. Du kan också radera ett spel genom att klicka "delete" knappen.

## SQL-kod
CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(40) NOT NULL UNIQUE
);

CREATE TABLE videoGames (
    gameID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(80) NOT NULL,
    description VARCHAR(255),
    is_completed BOOLEAN DEFAULT FALSE,
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES users(userID)
);



---

Viktor Ekström
