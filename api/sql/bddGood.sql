
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Delete database
--
DROP DATABASE IF EXISTS projet_web_IV_PL;
DROP USER IF EXISTS 'leopoldUSER'@'localhost';

--
-- Create Database
-- 
CREATE DATABASE projet_web_IV_PL;

--
-- Create user
--
CREATE USER 'leopoldUSER'@'localhost' IDENTIFIED BY 'phpInMyHeart333!!!';
GRANT ALL PRIVILEGES ON projet_web_IV_PL.* TO 'leopoldUSER'@'localhost';
FLUSH PRIVILEGES;

USE projet_web_IV_PL;


--
-- Table: ville
--
CREATE TABLE ville(
        code_insee  Int NOT NULL ,
        ville       Varchar (50) NOT NULL ,
        code_postal Varchar (50) NOT NULL
	,CONSTRAINT ville_PK PRIMARY KEY (code_insee)
)ENGINE=InnoDB;

INSERT INTO `ville` (`code_insee`, `ville`, `code_postal`) VALUES
(29015, 'BOURG BLANC', '29860'),
(29061, 'GOUESNOU', '29850'),
(29185, 'PLOUESCAT', '29430'),
(29260, 'ST RENAN', '29290');


-- 
-- Table: categorie_age
-- 

CREATE TABLE categorie_age(
        categorie Varchar (150) NOT NULL
	,CONSTRAINT categorie_age_PK PRIMARY KEY (categorie)
)ENGINE=InnoDB;

INSERT INTO `categorie_age` (`categorie`) VALUES
('Ancien'),
('Benjamin'),
('Cadet'),
('Féminine'),
('Junior'),
('Minime'),
('Poussin'),
('Pupille'),
('Sénior'),
('Super Vétéran'),
('Vétéran');


-- 
-- Table: categorie_valeur
-- 

CREATE TABLE categorie_valeur(
        categorie Varchar (150) NOT NULL
	,CONSTRAINT categorie_valeur_PK PRIMARY KEY (categorie)
)ENGINE=InnoDB;

INSERT INTO `categorie_valeur` (`categorie`) VALUES
('1ere cat'),
('2eme  cat'),
('3eme  cat'),
('4eme  cat'),
('5eme  cat');

-- 
-- Table: user
-- 

CREATE TABLE user(
        mail     Varchar (150) NOT NULL ,
        nom      Varchar (150) NOT NULL ,
        prenom   Varchar (150) NOT NULL ,
        password Varchar (150) NOT NULL ,
        admin    Bool
	,CONSTRAINT user_PK PRIMARY KEY (mail)
)ENGINE=InnoDB;

INSERT INTO `user` (`mail`, `nom`, `prenom`, `password`, `admin`) VALUES
('jlr@mental.com', 'Thered', 'John', 'smiley', NULL),
('mccall@serie.fr', 'Hunter', 'Rick', 'deedee', NULL),
('te@warnerbros.com', 'Egeri', 'Tom', 'thecat', 1),
('ts@magnum.com', 'Sailec', 'Tom', 'higgins', NULL);


-- 
-- Table: club
-- 

CREATE TABLE club(
        club       Varchar (50) NOT NULL ,
        mail       Varchar (150) NOT NULL ,
        code_insee Int NOT NULL
	,CONSTRAINT club_PK PRIMARY KEY (club)

	,CONSTRAINT club_user_FK FOREIGN KEY (mail) REFERENCES user(mail)
	,CONSTRAINT club_ville0_FK FOREIGN KEY (code_insee) REFERENCES ville(code_insee)
	,CONSTRAINT club_user_AK UNIQUE (mail)
)ENGINE=InnoDB;

INSERT INTO `club` (`club`, `mail`, `code_insee`) VALUES
('ABC PLOUESCAT', 'jlr@mental.com', 29185),
('AC GOUESNOU', 'mccall@serie.fr', 29061),
('CC BOURG BLANC', 'te@warnerbros.com', 29015),
('SAINT RENAN.I.V', 'ts@magnum.com', 29260);



-- 
-- Table: cycliste
-- 

CREATE TABLE cycliste(
        mail                       Varchar (100) NOT NULL ,
        nom                        Varchar (50) NOT NULL ,
        prenom                     Varchar (50) NOT NULL ,
        num_licence                Int ,
        date_naissance             Date ,
        valide                     Bool ,
        club                       Varchar (50) NOT NULL ,
        code_insee                 Int NOT NULL ,
        categorie                  Varchar (150) NOT NULL ,
        categorie_categorie_valeur Varchar (150) NOT NULL
	,CONSTRAINT cycliste_PK PRIMARY KEY (mail)

	,CONSTRAINT cycliste_club_FK FOREIGN KEY (club) REFERENCES club(club)
	,CONSTRAINT cycliste_ville0_FK FOREIGN KEY (code_insee) REFERENCES ville(code_insee)
	,CONSTRAINT cycliste_categorie_age1_FK FOREIGN KEY (categorie) REFERENCES categorie_age(categorie)
	,CONSTRAINT cycliste_categorie_valeur2_FK FOREIGN KEY (categorie_categorie_valeur) REFERENCES categorie_valeur(categorie)
)ENGINE=InnoDB;

INSERT INTO `cycliste` (`mail`, `nom`, `prenom`, `num_licence`, `date_naissance`, `valide`, `club`, `code_insee`, `categorie`, `categorie_categorie_valeur`) VALUES
('ac@fgt.com', 'ABIVEN', 'Christophe', 55602886, NULL, NULL, 'CC BOURG BLANC', 29061, 'Sénior', '2eme  cat'),
('ac@hgt.fr', 'ARNAUD', 'Cédric', 55544762, NULL, 1, 'AC GOUESNOU', 29061, 'Sénior', '2eme  cat'),
('cl@team.gt', 'COLLET', 'Louis', 695576, NULL, NULL, 'ABC PLOUESCAT', 29061, 'Vétéran', '2eme  cat'),
('dj@taem.com', 'DUDORET', 'Joël', 55654078, NULL, 1, 'ABC PLOUESCAT', 29185, 'Sénior', '1ere cat'),
('kc@pli.fr', 'KERMORGANT', 'Cyril', 695582, NULL, NULL, 'SAINT RENAN.I.V', 29260, 'Vétéran', '3eme  cat'),
('lb@team.fr', 'LUCAS', 'Benjamin', 267406, NULL, NULL, 'ABC PLOUESCAT', 29185, 'Ancien', '1ere cat'),
('lg@team.fr', 'LE GLEAU', 'Alain', 55477384, NULL, 1, 'AC GOUESNOU', 29015, 'Sénior', '1ere cat'),
('md@ilg.com', 'MOYSAN', 'David', 55537517, NULL, 1, 'ABC PLOUESCAT', 29015, 'Super Vétéran', '2eme  cat'),
('my@trez.fr', 'MEVEL', 'Yann', 369676, NULL, 1, 'AC GOUESNOU', 29061, 'Vétéran', '1ere cat'),
('pc@uti.fr', 'PREVOT', 'Christophe', 55654078, NULL, 1, 'CC BOURG BLANC', 29061, 'Super Vétéran', '3eme  cat'),
('sjm@rest.ft', 'SALIOU', 'Jean Marc', 135645, NULL, 1, 'AC GOUESNOU', 29185, 'Vétéran', '2eme  cat'),
('tb@opf.com', 'TIRILLY', 'Bertrand', 674243, NULL, NULL, 'SAINT RENAN.I.V', 29260, 'Vétéran', '5eme  cat');

-- 
-- Table: course
-- 

CREATE TABLE course(
        id            Int  Auto_increment  NOT NULL ,
        libelle       Varchar (150) NOT NULL ,
        date          Date NOT NULL ,
        nb_tour       Double NOT NULL ,
        distance      Double NOT NULL ,
        nb_coureur    Int NOT NULL ,
        longueur_tour Double NOT NULL ,
        club          Varchar (50) NOT NULL
	,CONSTRAINT course_PK PRIMARY KEY (id)

	,CONSTRAINT course_club_FK FOREIGN KEY (club) REFERENCES club(club)
)ENGINE=InnoDB;

INSERT INTO `course` (`id`, `libelle`, `date`, `nb_tour`, `distance`, `nb_coureur`, `longueur_tour`, `club`) VALUES
(1, 'Course Cycliste FSGT à GOUESNOU (29)', '2019-05-20', 12, 87.6, 50, 7.3, 'AC GOUESNOU');
INSERT INTO `course` (`id`, `libelle`, `date`, `nb_tour`, `distance`, `nb_coureur`, `longueur_tour`, `club`) VALUES
(2, 'Course Cycliste FSGT à Brest (29)', '2020-07-20', 12, 87.6, 50, 7.3, 'AC GOUESNOU');

-- 
-- Table: participe
-- 

CREATE TABLE participe(
        mail    Varchar (100) NOT NULL ,
        id      Int NOT NULL ,
        place   Varchar (15) NULL ,
        dossart Varchar (15) NULL ,
        point   Int NULL ,
        temps   Time NULL
	,CONSTRAINT participe_PK PRIMARY KEY (mail,id)

	,CONSTRAINT participe_cycliste_FK FOREIGN KEY (mail) REFERENCES cycliste(mail)
	,CONSTRAINT participe_course0_FK FOREIGN KEY (id) REFERENCES course(id)
)ENGINE=InnoDB;


INSERT INTO `participe` (`mail`, `id`, `place`, `dossart`, `point`, `temps`) VALUES
('ac@fgt.com', 1, '1', '55', 15, '02:04:04'),
('ac@hgt.fr', 1, '2', '76', 10, '02:07:04'),
('cl@team.gt', 1, '3', '81', 8, '02:14:04'),
('dj@taem.com', 1, '4', '55', 7, '02:24:04'),
('kc@pli.fr', 1, '5', '21', 4, '02:34:04'),
('lb@team.fr', 1, '6', '18', 3, '02:44:04');




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
