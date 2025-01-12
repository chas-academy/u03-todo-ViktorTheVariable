# U03-todo

[Länk till ER-Diagram](https://www.figma.com/design/oGqJhH8jCxsHc1e2w2Qg6W/U03-ERDiagram-FigmaSkiss?node-id=0-1&p=f&t=LLaNUQibLpP9yzGb-0)

[Länk till figma-skiss](https://www.figma.com/design/oGqJhH8jCxsHc1e2w2Qg6W/U03-ERDiagram-FigmaSkiss?node-id=0-1&p=f&t=LLaNUQibLpP9yzGb-0)

## Instruktioner
1. **Krav**<br>
Innan du börjar, se till att du har följande installerat på din dator:
* Docker (version 20.10 eller högre)
* Docker Compose (version 1.27 eller högre)
2. **Klona eller ladda ner koden**<br>
Klona eller ladda ner källkoden från [repository-länk] och extrahera den till en mapp på din dator.
3. **Strukturera projektet**<br>
Se till att din mappstruktur ser ut som följande:
text
/project-root<br>
│<br>
├── src<br>
│   ├── index.php<br>
│   ├── db.php<br>
│   ├── crud-functions.php<br>
│   ├── style<br>
│   │   └── style.css<br>
│   ├── assets<br>
│   │   └── logo.png<br>
│   └── seed<br>
│       └── sql-seed.sql<br>
│
├── Dockerfile<br>
└── docker-compose.yml
4. **Bygg och starta containrarna**<br>
Navigera till projektets rotmapp där docker-compose.yml finns och kör följande kommando:<br>
bash<br>
docker-compose up<br>
Detta kommando kommer att:
* Bygga PHP-applikationen med Apache.
* Starta en MariaDB-databas.
* Starta Adminer för databasadministration.
5. **Åtkomst till applikationen**<br>
Öppna din webbläsare och navigera till http://localhost för att komma åt applikationen.
6. **Åtkomst till Adminer**<br>
För att hantera databasen kan du använda Adminer. Öppna din webbläsare och navigera till http://localhost:8080. Logga in med följande uppgifter:<br>
Server: mariadb<br>
Användarnamn: root<br>
Lösenord: v.E<br>
Databas: U03-todo
7. **Använd applikationen**
* Fyll i användarnamn, spel titel och beskrivning i formuläret.
* Klicka på "Add a game to a list" för att lägga till spelet i din lista.
* Klicka på "Show your list of games" för att visa listan.
* Du klickar i checkboxen till höger om game finished? kolumnen i listan och trycker sedan på "save" knappen för att spara statusen.
* Du uppdaterar ett spels title och beskrivning i listan genom att klicka "change" knappen och skriver in den nya datan i dom båda formulären och sedan klicka på "update game" knappen.
* Du kan också radera ett spel genom att klicka "delete" knappen.

## SQL-kod
CREATE TABLE users (<br>
    userID INT AUTO_INCREMENT PRIMARY KEY,<br>
    username VARCHAR(40) NOT NULL UNIQUE<br>
);<br>
<br>
CREATE TABLE videoGames (<br>
    gameID INT AUTO_INCREMENT PRIMARY KEY,<br>
    title VARCHAR(80) NOT NULL,<br>
    description VARCHAR(255),<br>
    is_completed BOOLEAN DEFAULT FALSE,<br>
    userID INT NOT NULL,<br>
    FOREIGN KEY (userID) REFERENCES users(userID)<br>
);

---

Viktor Ekström
