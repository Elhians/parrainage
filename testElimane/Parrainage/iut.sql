# source C:/Code/Sql/mysql/iut2013.sql

# source C:/Code/Sql/Material/film.sql


# source C:/Lecture/DB/Materiel/iut2013.sql

#   \i C:/Code/Sql/Material/iut.sql
#  \i C:/Code/Sql/Material/iut.sql
DROP DATABASE IF EXISTS iut;
create database iut;
use iut ; #utilise la base iut 


create table etudiant ( idEtud int auto_increment,
		nom varchar(32) default 'Ndiaye',
		prenom varchar(32) default 'Ablaye',
		classe enum ('L1', 'L2', 'L3'),
		constraint pk_Etud primary key (idEtud)) ENGINE=INNODB;

create table enseignant (idEns int,
		nom varchar(32),
		prenom varchar(32),
		constraint pk_Ens primary key (idEns) ) ENGINE=INNODB;

create table matiere (idMat int,
		libelle varchar(32),
		classe varchar(3),
		responsable int, 
		constraint pk_Mat primary key (idMat),
		constraint ck_classe check (classe in ('L1', 'L2', 'L3')),
		constraint fk_ens foreign key (responsable) references enseignant (idEns) ) ENGINE=INNODB;

create table interro (idInterro int,
		idMatiere int,
		constraint pk_Int primary key (idInterro),
		constraint fk_mat foreign key (idMatiere) references matiere (idMat) )ENGINE=INNODB;

create table notes (idInterro int,
		idEtud int,
		note float,
		constraint pk_Not primary key (idInterro, idEtud),
		constraint fk_interro foreign key (idInterro) references interro (idInterro),
		constraint fk_etudiant foreign key (idEtud) references etudiant (idEtud),
constraint ck_note check ( ((note >= 0.0) and (note <= 20.0)) or (note is null) )    		)    ENGINE=INNODB;

# constraint ck_note check ( (note > 0.0) and (note < 20.0)


insert into enseignant (idEns, nom, prenom) VALUES 
	(1, 'Ndao','Fatou');
insert into enseignant (idEns, nom, prenom) VALUES 
	(2, 'Sarr','Moussa');
insert into enseignant (idEns, nom, prenom) VALUES 
	(3, 'Camara', 'Mamadou');
insert into enseignant (idEns, nom, prenom) VALUES 
	(4, 'Fall','Ibrahima');
insert into enseignant (idEns, nom, prenom) VALUES 
	(5, 'Keita','Khadija');
insert into enseignant (idEns, nom, prenom) VALUES 
	(7, 'Bah','Alassane');
insert into enseignant (idEns, nom, prenom) VALUES 
	(8, 'Niass','Coura');



insert into etudiant (nom, prenom, classe) VALUES
	('Ndiaye','Moussa', 'L2');
insert into etudiant ( nom, prenom, classe) VALUES
	('Diop', 'Anta', 'L2');
insert into etudiant (nom, prenom, classe) VALUES
	('Santos', 'Jordan', 'L2');
insert into etudiant (nom, prenom, classe) VALUES
	('Sow', 'Ardo', 'L1');
insert into etudiant ( nom, prenom, classe) VALUES
	('Lo', 'Moukhtar', 'L1');
insert into etudiant (nom, prenom, classe) VALUES
	('Ndiaye', 'Khady', 'L1');
insert into etudiant (nom, prenom, classe) VALUES
	('Thiam', 'Mouhamed', 'L1');
insert into matiere VALUES (1, 'Math', 'L1', 4);
insert into matiere VALUES (2, 'Math', 'L2', 4);
insert into matiere VALUES (3, 'EOG', 'L1', 5);
insert into matiere VALUES (4, 'EOG', 'L2', 5);
insert into matiere VALUES (5, 'ACSI', 'L1', 3);
insert into matiere VALUES (6, 'ACSI', 'L2', 2);
insert into matiere VALUES (7, 'DROIT', 'L2', 5);


insert into interro VALUES (1,1);
insert into interro VALUES (2,3);
insert into interro VALUES (3,6);
insert into interro VALUES (4,1);
insert into interro VALUES (5,1);
insert into interro VALUES (6,1);

insert into notes VALUES	(1, 04, 20);
insert into notes VALUES	(1, 05, 13);
insert into notes VALUES	(2, 04, 14);
insert into notes VALUES	(2, 05, 9);
insert into notes VALUES	(3, 01, 12);
insert into notes VALUES	(3, 02, 16);
insert into notes VALUES	(3, 03, 10);
insert into notes VALUES	(4, 4, 12);
insert into notes VALUES	(4, 5, NULL);
insert into notes VALUES	(5, 4, 8);
insert into notes VALUES	(5, 5, 12);
insert into notes VALUES	(6, 4, 8);

 select * from etudiant;
 select * from matiere;
 select * from interro;
 select * from notes;
 select * from enseignant;
 