### Regarde di l'utilisateur existe et renvoie son grade
SELECT admin FROM user WHERE mail="te@warnerbros.com" AND password="thecat";
SELECT admin FROM user WHERE mail="jlr@mental.com" AND password="smiley";


#### Requêtes pour course
### Test si le responsable est le créateur de la course
SELECT co.date 
FROM course co
JOIN club c ON c.club = co.club
JOIN user u ON c.mail = u.mail
#WHERE u.nom = "Egeri" AND u.prenom = "Tom" AND co.id = 1;	#Personne qui crée les courses
WHERE u.nom = "Hunter" AND u.prenom = "Rick" AND co.id = 1;

### Récupère tous les participants d'une course sans prendre en compte les clubs
SELECT cy.nom, cy.prenom, cy.mail, cy.num_licence, cy.categorie, cy.club, p.dossart
FROM cycliste cy
JOIN participe p ON p.mail = cy.mail
WHERE p.id = 1;

### Récupère tous les participants d'un club participants à une course
SELECT cy.nom, cy.prenom, cy.mail, cy.num_licence, cy.categorie, cy.club, p.dossart
FROM participe p
JOIN cycliste cy ON p.mail = cy.mail
JOIN club cl ON cl.club = cy.club
JOIN user u ON u.mail = cl.mail
WHERE p.id = 1 AND u.nom = "Egeri" AND u.prenom = "Tom";


###
SELECT valide FROM cycliste WHERE nom = "ABIVEN" AND prenom = "Christophe" AND mail = "ac@fgt.com";

INSERT INTO participe (mail, id, dossart) VALUES ("dj@taem.com", 2, 7);
DELETE FROM participe WHERE id = 2;