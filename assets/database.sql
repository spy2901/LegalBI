DROP DATABASE IF EXISTS legalBI;

CREATE DATABASE IF NOT EXISTS legalBI;

USE legalBI;

CREATE TABLE IF NOT EXISTS korisnici (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    uloga ENUM('admin','analiticar','operativni') NOT NULL,
    datum_kreiranja TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `korisnici` (`id`, `username`, `password_hash`, `uloga`, `datum_kreiranja`) VALUES (NULL, 'admin', '$2y$10$KpOPJae3eqxCN5cTs7n4xeYgYuH.ltnJXYMyiEBn.Bcxc1urvtiHG', 'admin', '2026-01-28 21:09:41')

-- =========================================
-- SUDOVI
-- =========================================
CREATE TABLE sudovi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(150) NOT NULL,
    grad VARCHAR(100),
    tip_suda ENUM('osnovni','visi','apelacioni','vrhovni')
);

-- =========================================
-- STRANKE
-- =========================================
CREATE TABLE stranke (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(150) NOT NULL,
    tip ENUM('fizicko_lice','pravno_lice') NOT NULL,
    maticni_broj VARCHAR(50),
    datum_kreiranja TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- PREDMETI
-- =========================================
CREATE TABLE predmeti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    broj_predmeta VARCHAR(100) NOT NULL UNIQUE,
    sud_id INT,
    tip_predmeta VARCHAR(100),
    datum_pokretanja DATE,
    status ENUM('aktivan','zavrsen','zalba') DEFAULT 'aktivan',
    vrednost_spora DECIMAL(15,2),
    datum_kreiranja TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sud_id) REFERENCES sudovi(id)
);

-- =========================================
-- VEZA PREDMET - STRANKA
-- =========================================
CREATE TABLE predmet_stranka (
    id INT AUTO_INCREMENT PRIMARY KEY,
    predmet_id INT NOT NULL,
    stranka_id INT NOT NULL,
    uloga ENUM('tuzilac','tuzeni','ostalo'),
    FOREIGN KEY (predmet_id) REFERENCES predmeti(id) ON DELETE CASCADE,
    FOREIGN KEY (stranka_id) REFERENCES stranke(id) ON DELETE CASCADE
);

-- =========================================
-- ADVOKATI
-- =========================================
CREATE TABLE advokati (
    id INT AUTO_INCREMENT PRIMARY KEY,
    puno_ime VARCHAR(150) NOT NULL,
    broj_licence VARCHAR(100),
    datum_kreiranja TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- VEZA PREDMET - ADVOKAT
-- =========================================
CREATE TABLE predmet_advokat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    predmet_id INT,
    advokat_id INT,
    uloga ENUM('advokat_tuzioca','advokat_tuzenog'),
    FOREIGN KEY (predmet_id) REFERENCES predmeti(id) ON DELETE CASCADE,
    FOREIGN KEY (advokat_id) REFERENCES advokati(id) ON DELETE CASCADE
);

-- =========================================
-- ROČIŠTA
-- =========================================
CREATE TABLE rocista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    predmet_id INT,
    datum_rocista DATE,
    ishod TEXT,
    FOREIGN KEY (predmet_id) REFERENCES predmeti(id) ON DELETE CASCADE
);

-- =========================================
-- PRESUDE
-- =========================================
CREATE TABLE presude (
    id INT AUTO_INCREMENT PRIMARY KEY,
    predmet_id INT,
    datum_presude DATE,
    rezultat ENUM('dobijen','izgubljen','delimicno','odbacen'),
    iznos_naknada DECIMAL(15,2),
    FOREIGN KEY (predmet_id) REFERENCES predmeti(id) ON DELETE CASCADE
);

-- =========================================
-- INDEKSI (optimizacija performansi)
-- =========================================
CREATE INDEX idx_predmeti_sud ON predmeti(sud_id);
CREATE INDEX idx_predmeti_status ON predmeti(status);
CREATE INDEX idx_rocista_predmet ON rocista(predmet_id);
CREATE INDEX idx_presude_predmet ON presude(predmet_id);
CREATE INDEX idx_predmet_stranka_predmet ON predmet_stranka(predmet_id);
CREATE INDEX idx_predmet_advokat_predmet ON predmet_advokat(predmet_id);



-- ================= D U M M Y  D A T A =================
-- 100 SUDOVA
INSERT INTO sudovi (naziv, grad, tip_suda)
SELECT 
    CONCAT('Sud ', n),
    CONCAT('Grad ', (n % 20) + 1),
    ELT(1 + (n % 4), 'osnovni','visi','apelacioni','vrhovni')
FROM (
    SELECT a.N + b.N*10 + 1 n
    FROM (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
         (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b
) nums
WHERE n <= 100;

-- 100 STRANAKA
INSERT INTO stranke (naziv, tip, maticni_broj)
SELECT 
    CONCAT('Stranka ', n),
    ELT(1 + (n % 2), 'fizicko_lice','pravno_lice'),
    LPAD(n,8,'0')
FROM (
    SELECT a.N + b.N*10 + 1 n
    FROM (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
         (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b
) nums
WHERE n <= 100;

-- 100 ADVOKATA
INSERT INTO advokati (puno_ime, broj_licence)
SELECT 
    CONCAT('Advokat ', n),
    CONCAT('LIC-', LPAD(n,5,'0'))
FROM (
    SELECT a.N + b.N*10 + 1 n
    FROM (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
         (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b
) nums
WHERE n <= 100;
-- 100 PREDMETA
INSERT INTO predmeti (broj_predmeta, sud_id, tip_predmeta, datum_pokretanja, status, vrednost_spora)
SELECT 
    CONCAT('P-2024-', LPAD(n,4,'0')),
    (n % 100) + 1,
    ELT(1 + (n % 5), 'krivicni','parnicni','privredni','upravni','porodicni'),
    DATE_ADD('2023-01-01', INTERVAL n DAY),
    ELT(1 + (n % 3), 'aktivan','zavrsen','zalba'),
    ROUND(RAND()*1000000,2)
FROM (
    SELECT a.N + b.N*10 + 1 n
    FROM (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
         (SELECT 0 N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b
) nums
WHERE n <= 100;

-- VEZE + ROČIŠTA + PRESUDE
INSERT INTO predmet_stranka (predmet_id, stranka_id, uloga)
SELECT id, id, ELT(1 + (id % 3), 'tuzilac','tuzeni','ostalo')
FROM predmeti;

INSERT INTO predmet_advokat (predmet_id, advokat_id, uloga)
SELECT id, id, ELT(1 + (id % 2), 'advokat_tuzioca','advokat_tuzenog')
FROM predmeti;

INSERT INTO rocista (predmet_id, datum_rocista, ishod)
SELECT id,
       DATE_ADD('2023-06-01', INTERVAL id DAY),
       CONCAT('Ishod ročišta ', id)
FROM predmeti;

INSERT INTO presude (predmet_id, datum_presude, rezultat, iznos_naknada)
SELECT id,
       DATE_ADD('2024-01-01', INTERVAL id DAY),
       ELT(1 + (id % 4), 'dobijen','izgubljen','delimicno','odbacen'),
       ROUND(RAND()*500000,2)
FROM predmeti;


ALTER TABLE predmeti
MODIFY COLUMN broj_predmeta VARCHAR(100) NOT NULL DEFAULT '';

ALTER TABLE predmeti
ADD COLUMN advokat VARCHAR(100) NOT NULL DEFAULT 'Nepoznato';

INSERT INTO predmeti (tip_predmeta, advokat)
VALUES
('Parnični', 'John Smith'),
('Krivični', 'Maria Garcia'),
('Upravni', 'Alex Johnson'),
('Parnični', 'Elena Rossi'),
('Krivični', 'David Lee'),
('Parnični', 'Sarah Brown'),
('Upravni', 'Michael Davis'),
('Krivični', 'Anna Wilson'),
('Parnični', 'Robert Martinez'),
('Upravni', 'Laura Taylor'),
('Parnični', 'Daniel Anderson'),
('Krivični', 'Emma Thomas'),
('Parnični', 'James Jackson'),
('Upravni', 'Olivia White'),
('Krivični', 'William Harris'),
('Parnični', 'Sophia Martin'),
('Upravni', 'Benjamin Thompson'),
('Krivični', 'Isabella Garcia'),
('Parnični', 'Lucas Rodriguez'),
('Upravni', 'Mia Lewis'),
('Parnični', 'Ethan Walker'),
('Krivični', 'Charlotte Hall'),
('Upravni', 'Alexander Allen'),
('Parnični', 'Amelia Young'),
('Krivični', 'Henry Hernandez'),
('Parnični', 'Emily King'),
('Upravni', 'Sebastian Wright'),
('Krivični', 'Grace Lopez'),
('Parnični', 'Liam Hill'),
('Upravni', 'Chloe Scott'),
('Parnični', 'Noah Green'),
('Krivični', 'Zoe Adams'),
('Upravni', 'Jack Baker'),
('Parnični', 'Ella Gonzalez'),
('Krivični', 'Oliver Nelson'),
('Upravni', 'Lily Carter'),
('Parnični', 'Mason Mitchell'),
('Krivični', 'Hannah Perez'),
('Upravni', 'Aiden Roberts'),
('Parnični', 'Sofia Turner'),
('Krivični', 'Jackson Phillips'),
('Upravni', 'Aria Campbell'),
('Parnični', 'Logan Parker'),
('Krivični', 'Scarlett Evans'),
('Upravni', 'David Edwards'),
('Parnični', 'Madison Collins'),
('Krivični', 'Samuel Stewart'),
('Upravni', 'Victoria Sanchez'),
('Parnični', 'Carter Morris'),
('Krivični', 'Penelope Rogers'),
('Upravni', 'Wyatt Reed'),
('Parnični', 'Luna Cook'),
('Krivični', 'Gabriel Morgan'),
('Upravni', 'Layla Bell'),
('Parnični', 'Caleb Murphy'),
('Krivični', 'Nora Bailey'),
('Upravni', 'Isaac Rivera'),
('Parnični', 'Hazel Cooper'),
('Krivični', 'Anthony Richardson'),
('Upravni', 'Aurora Cox'),
('Parnični', 'Joshua Howard'),
('Krivični', 'Ellie Ward'),
('Upravni', 'Christian Torres'),
('Parnični', 'Violet Peterson'),
('Krivični', 'Nathan Gray'),
('Upravni', 'Stella Ramirez'),
('Parnični', 'Dylan James'),
('Krivični', 'Paisley Watson'),
('Upravni', 'Leo Brooks'),
('Parnični', 'Hannah Kelly'),
('Krivični', 'Jonathan Sanders'),
('Upravni', 'Savannah Price'),
('Parnični', 'Andrew Bennett'),
('Krivični', 'Bella Wood'),
('Upravni', 'Thomas Barnes'),
('Parnični', 'Audrey Ross'),
('Krivični', 'Eli Henderson'),
('Upravni', 'Lucy Coleman'),
('Parnični', 'Christopher Jenkins'),
('Krivični', 'Camila Perry'),
('Upravni', 'Julian Powell'),
('Parnični', 'Ruby Long'),
('Krivični', 'Isaiah Patterson'),
('Upravni', 'Alice Hughes'),
('Parnični', 'Dominic Flores'),
('Krivični', 'Clara Washington'),
('Upravni', 'Maxwell Butler'),
('Parnični', 'Ivy Simmons'),
('Krivični', 'Asher Foster'),
('Upravni', 'Eliana Gonzales'),
('Parnični', 'Lincoln Bryant'),
('Krivični', 'Madelyn Alexander'),
('Upravni', 'Grayson Russell'),
('Parnični', 'Willow Griffin'),
('Krivični', 'Sebastian Diaz'),
('Upravni', 'Elena Hayes'),
('Parnični', 'Levi Myers'),
('Krivični', 'Aurora Ford'),
('Upravni', 'Elias Hamilton'),
('Parnični', 'Clara Graham'),
('Krivični', 'Mateo Sullivan'),
('Upravni', 'Lillian Wallace'),
('Parnični', 'Wyatt West'),
('Krivični', 'Addison Cole'),
('Upravni', 'Christian Jordan'),
('Parnični', 'Penelope Reynolds'),
('Krivični', 'Leo Fisher'),
('Upravni', 'Hazel Ellis'),
('Parnični', 'Jaxon Harrison'),
('Krivični', 'Aria Gibson'),
('Upravni', 'Ezra McDonald'),
('Parnični', 'Aurora Cruz'),
('Krivični', 'Hunter Marshall'),
('Upravni', 'Nora Ortiz'),
('Parnični', 'Cameron Rice'),
('Krivični', 'Violet Stone'),
('Upravni', 'Isaac Kim');