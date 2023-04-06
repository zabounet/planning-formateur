CREATE TABLE Type_Formation(
        id_type_formation          Int  Auto_increment  NOT NULL ,
        designation_type_formation Varchar (16) NOT NULL
	,CONSTRAINT Type_Formation_PK PRIMARY KEY (id_type_formation)
)ENGINE=InnoDB;


CREATE TABLE Couleurs(
        couleur_id      Int  Auto_increment  NOT NULL ,
        couleur_centre  Char (7) NOT NULL ,
        couleur_pae     Char (7) NOT NULL ,
        couleur_certif  Char (7) NOT NULL ,
        couleur_ran     Char (7) NOT NULL ,
        couleur_vacance Char (7) NOT NULL ,
        couleur_tt      Char (7) NOT NULL ,
        couleur_ferie   Char (7) NOT NULL ,
        couleur_weekend Char (7) NOT NULL
	,CONSTRAINT Couleurs_PK PRIMARY KEY (couleur_id)
)ENGINE=MyISAM;


CREATE TABLE Interruption(
        id_date_interruption    Int  Auto_increment  NOT NULL ,
        date_debut_interruption Date NOT NULL ,
        date_fin_interruption   Date NOT NULL
	,CONSTRAINT Interruption_PK PRIMARY KEY (id_date_interruption)
)ENGINE=InnoDB;


CREATE TABLE GRM(
        numero_grm Int NOT NULL ,
        nom_grm    Varchar (32) NOT NULL
	,CONSTRAINT GRM_PK PRIMARY KEY (numero_grm)
)ENGINE=InnoDB;


CREATE TABLE Formateur(
        id_formateur           Int  Auto_increment  NOT NULL ,
        nom_formateur          Varchar (64) NOT NULL ,
        prenom_formateur       Varchar (64) NOT NULL ,
        mail_formateur         Varchar (128) NOT NULL ,
        mdp_formateur          Varchar (255) NOT NULL ,
        type_contrat_formateur Char (3) NOT NULL ,
        date_debut_contrat     Date ,
        date_fin_contrat       Date ,
        numero_grm             Int NOT NULL
	,CONSTRAINT Formateur_PK PRIMARY KEY (id_formateur)
)ENGINE=InnoDB;


CREATE TABLE Date_formation(
        id_date_formation    Int  Auto_increment  NOT NULL ,
        date_debut_formation Date NOT NULL ,
        date_fin_formation   Date NOT NULL ,
        id_formation         Int NOT NULL
	,CONSTRAINT Date_formation_PK PRIMARY KEY (id_date_formation)
)ENGINE=InnoDB;


CREATE TABLE Date_pae(
        id_date_pae    Int  Auto_increment  NOT NULL ,
        date_debut_pae Date NOT NULL ,
        date_fin_pae   Date NOT NULL ,
        id_formation   Int NOT NULL
	,CONSTRAINT Date_pae_PK PRIMARY KEY (id_date_pae)
)ENGINE=InnoDB;


CREATE TABLE Date_certif(
        id_certif         Int  Auto_increment  NOT NULL ,
        date_debut_certif Date NOT NULL ,
        date_fin_certif   Date NOT NULL ,
        id_formation      Int NOT NULL
	,CONSTRAINT Date_certif_PK PRIMARY KEY (id_certif)
)ENGINE=InnoDB;


CREATE TABLE Formation(
        id_formation          Int  Auto_increment  NOT NULL ,
        acronyme_formation    Varchar (10) NOT NULL ,
        description_formation Varchar (128) NOT NULL ,
        numero_grm            Int NOT NULL ,
        id_ran                Int NOT NULL ,
        id_type_formation     Int NOT NULL ,
        id_date_formation     Int NOT NULL ,
        id_certif             Int NOT NULL ,
        id_date_pae           Int NOT NULL ,
        id_formateur          Int NOT NULL
	,CONSTRAINT Formation_PK PRIMARY KEY (id_formation)
)ENGINE=InnoDB;


CREATE TABLE Date_ran(
        id_ran         Int  Auto_increment  NOT NULL ,
        date_debut_ran Date NOT NULL ,
        date_fin_ran   Date NOT NULL ,
        id_formation   Int NOT NULL
	,CONSTRAINT Date_ran_PK PRIMARY KEY (id_ran)
)ENGINE=InnoDB;
