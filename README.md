[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/5k4uDUDX)

# U03-todo
Projekt påbörjat
## Projektide

### MVP
Som en första MVP ska jag skapa en minimalistisk användarvänlig one-page sida på engelska för mobil där användare upprepande gånger ska kunna skriva in en speltitel samt en spelbeskrivning, för att sedan få upp dessa i en tabell där även ordningsnummer och en bocka av/på knapp ska finnas. Användaren ska kunna ändra titel/beskrivning på varje tabellrad samt ta bort eller lägga till en rad. Det ska även gå att bocka för spelet som färdigspelat. 

### Feature expansion 
Om tid finnes kommer jag först göra designen lite snyggare med bilder, ikoner, bakgrundsbilder och ett enhetligt färgschema samt göra desigen respoonsiv för användning på desktop och andra enheter. Sedan lägga till funktionerna: Användare ska kunna välja spel från en inlagd lista av spel där kategorier som spelkonsoll, spelgenre, metacritic rating och ordinarie pris också visas upp. Användare ska själv kunna lägga till dessa kategorier också. Listan ska kunna sparas i local-storage för använding ett senare tillfälle.

## Plan
1. Skapa ER-Diagram i figma
2. Skapa mobildesign i figma
3. Skapa filstruktur i VsCode
4. Bygga en container med mariaDB i docker
5. Skapa en databas och koppla den till PDO
6. Skapa PHP-vyer med grundläggande HTML och css
7. Bygga mina SQL frågor med PDO.
8. Koppla ihop vyerna med sin backend
9. Finslipa HTML struktur och design i CSS
10. Testa sin applikation.

## Utförande

### ER-Diagram
![ER-Diagram](https://github.com/user-attachments/assets/ab4bea14-d1bf-41be-a5f0-381ccc59d793)
[Länk till ER-Diagram](https://www.figma.com/design/oGqJhH8jCxsHc1e2w2Qg6W/U03-ERDiagram-FigmaSkiss?node-id=0-1&p=f&t=LLaNUQibLpP9yzGb-0)
<br>
En tabell kommer behövas då enbart användarens input av titel och beskrivning kommer att läggas in i databasen tillsammans med ID och klar/icke-klar kolumnerna. ID kommer vara ett nummer som automatiskt ökar för varje tabellrad och behöver därför vara INT och auto_increment. Jag har satt denna som primary key för att unikt kunna identifiera varje tabellrad. Title ska vara en sträng med ett spelnamn som användaren skriver in, har satt VARCHAR till 80 för att begränsa antalet tecken i kolumnen då flesta speltitlar har 20-40 tecken och NOT NULL för att ett definierat värde ska finnas i kolumnen. Description ska vara en sträng med spelbeskrivning, VARCHAR(255) för att besgränsa antalet tecken och få en kort beskrivning av spelet. is_completed ska vara en klar/icke-klar ruta som representeras genom ett TRUE/FALSE värde och ska därför vara BOOLEAN med ett DEFAULT värde av FALSE där anävndaren själv bockar av spelet som spelat och gör det till TRUE. Uppdatering: KOm på att jag behöver lite fler tabeller annars kommer man behöva sudda uppgifts tabellen varje gång nån går bort från sidan för att det ska fungera. Och 2 eller flera användare kommer inte kunna använda sidan samtidigt då dessa kommer skapa och sedan visa upp sina egna plus andra användarens spel i listan. jag kopplade ihop tabellerna genon att sätta userID som främmande nyckel i lists tabellen och listID som färmmande nyckel i videoGames tabellen. Uppdatering: Insåg att det räckte med 2 tabeller och pga tidsbrist bytte jag till 2 för att slippa extra tid i logiken med 3 tabeller. Är samma users tabell men som länkar 1:N med videoGames tabellen där videogames byter ut foreign key för listID till userID.

### Figma-Skiss
![Skärmbild 2024-12-29 054915](https://github.com/user-attachments/assets/aa178b8e-0741-44a2-85c6-a54b9a79ebf0)
[Länk till figma-skiss](https://www.figma.com/design/oGqJhH8jCxsHc1e2w2Qg6W/U03-ERDiagram-FigmaSkiss?node-id=0-1&p=f&t=LLaNUQibLpP9yzGb-0)

### Filstruktur
Filstruktur skapad i VsCode med filerna: Dockerfile, docker-compose.yml, index.php, db.php, sql-seed.sql, style.css, index.php. Även bilden som ska användas, figmas-skissen och ER-diagrammet lades in i assets mappen.

### Container med MariaDB
En container skapades med databasen U03-todo. En tabell videoGames enligt ER-Diagrmmet skapades också via sql-seed.sql filen när containern skpades.

### Skapa en databas och koppla den till PDO
tre tabeller enligt ER-Diagrmmet skapades via sql-seed.sql filen när containern skpades. Databasen kopplades sedan ihop med PDO i db.php filen.

### Skapa PHP-vyer med grundläggande HTML och css
html strukturen och css styling skapad för att se ut någolunda som figma skissen. Nu kan jag bygga crud functionerna och testa dem på sidan.

### Bygga mina SQL-Frågor med PDO

1. jag började med att skapa en funktion för att antingen hämta användarID från databasen om den redan finns eller skapa ett nytt användarID om det som användaren ska skriva in inte finns i databasen. Sedan skapade jag logiken för att köra denna funktion.
2. Jag skapade en funktion för att lägga till ett spel (och för tillfället annan text) som via användarens inmatning i det title och description inputfälten tillsammans med användarID:t lägger till inputs från de båda i respektive kolumn i databasen. Logik skapades för att köra funktionen och formulär i index.php modifierades för att passa ihop med logiken och köra funktionen med en knapptryckning.
3. Jag skapade en funktion för att hämta all data från databasen som tillhär en visst användarId och logiken för denna som  sedan via en knapptryckning repreneteras i en tabell som jag också skapade i index.php.
4. Jag skapade en funktion för att toggla en checkbox som iffyld lägger in true och inte ifylld lägger in false i databasen som representeras på sidan genom en användares input som sedan updateras och sparas via en knapp.
5. Skapade sedan en funktion för att uppdatera en spel med ny titel och beskrivning och logik för att köra den. I index.php lade jag till ett hidden formulär som visas via en knapptryckning. Jag la även till en variabel $showlist i logiken med värdet false för att i index.php sätta värdet till true via en vilkorsats om knappen för att visa listan trycks på av användaren.
6. Sist la jag till en funktion för att radera ett spel från listan och spara denna radering i databasen. logik skapades för funktionen och ett modifierat formulär i index.php skapades också för att radera spelet via användares input.

---

Viktor Ekström
