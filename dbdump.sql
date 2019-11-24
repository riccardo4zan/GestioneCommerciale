CREATE TABLE Utenti( username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(username) );

CREATE TABLE Clienti( piva CHAR(11) NOT NULL, nome CHAR(50) NOT NULL, indirizzo CHAR(50), PRIMARY KEY(piva) );

CREATE TABLE Prodotti( codice CHAR(10) NOT NULL, nome CHAR(40) NOT NULL, prezzo DECIMAL(10,2), PRIMARY KEY(codice) );

CREATE TABLE Ordini( id INT(11) AUTO_INCREMENT NOT NULL, piva CHAR(11) NOT NULL, dataord DATE , PRIMARY KEY(id) , FOREIGN KEY (piva) REFERENCES Clienti(piva) ON UPDATE CASCADE ON DELETE CASCADE ) ENGINE = INNODB ;

CREATE TABLE DettaglioOrdine( nord INT(11) NOT NULL, codprod CHAR(10) NOT NULL, qta INT(8), PRIMARY KEY(nord, codprod), FOREIGN KEY (nord) REFERENCES Ordini(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (codprod) REFERENCES Prodotti(codice) ON UPDATE CASCADE ON DELETE CASCADE ) ENGINE = INNODB ;

CREATE VIEW OrdiniNomiClienti AS SELECT id, Clienti.piva , nome, dataord FROM Ordini, Clienti WHERE Clienti.piva = Ordini.piva ;

CREATE VIEW OrdineNomeProdottiPrezzo AS SELECT nord, qta, codprod, nome, prezzo FROM Prodotti, DettaglioOrdine WHERE Prodotti.codice = DettaglioOrdine.codprod ;

/Password = admin/ INSERT INTO Utenti VALUES('Administrator','$2y$10$a8TlBGzRYbz.8dbwancWSObUhrIs7V1jP2VjWgSBl8EHWKgxhpRvy');

INSERT INTO Clienti(piva, nome, indirizzo) VALUES ('00000000001','Cliente1','Via prova 1'); INSERT INTO Prodotti(codice, nome, prezzo) VALUES ('1','Prodotto1','10'); INSERT INTO Ordini(piva, dataord) VALUES ('00000000001','2018-04-03'); INSERT INTO DettaglioOrdine(nord, codprod, qta) VALUES ('1','1','1');
