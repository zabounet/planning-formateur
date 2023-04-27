#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Type Formation
#------------------------------------------------------------

CREATE TABLE Type_Formation(
        id_type_formation          Int  Auto_increment  NOT NULL ,
        designation_type_formation Varchar (16) NOT NULL
	,CONSTRAINT Type_Formation_PK PRIMARY KEY (id_type_formation)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Couleurs
#------------------------------------------------------------

CREATE TABLE Couleurs(
        couleur_id                Int  Auto_increment  NOT NULL ,
        couleur_centre            Char (7) NOT NULL ,
        couleur_pae               Char (7) NOT NULL ,
        couleur_certif            Char (7) NOT NULL ,
        couleur_ran               Char (7) NOT NULL ,
        couleur_vacance_demandees Char (7) NOT NULL ,
        couleur_vacance_validee   Char (7) NOT NULL ,
        couleur_tt                Char (7) NOT NULL ,
        couleur_ferie             Char (7) NOT NULL ,
        couleur_weekend           Char (7) NOT NULL ,
        couleur_interruption      Char (7) NOT NULL ,
        couleur_MNSP              Char (7) NOT NULL ,
        couleur_itinerant         Char (7) NOT NULL
	,CONSTRAINT Couleurs_PK PRIMARY KEY (couleur_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GRN
#------------------------------------------------------------

CREATE TABLE GRN(
        numero_grn Int NOT NULL ,
        nom_grn    Varchar (32) NOT NULL
	,CONSTRAINT GRN_PK PRIMARY KEY (numero_grn)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Ville
#------------------------------------------------------------

CREATE TABLE Ville(
        id_ville  Int  Auto_increment  NOT NULL ,
        nom_ville Varchar (128) NOT NULL
	,CONSTRAINT Ville_PK PRIMARY KEY (id_ville)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Formateur
#------------------------------------------------------------

CREATE TABLE Formateur(
        id_formateur            Int  Auto_increment  NOT NULL ,
        nom_formateur           Varchar (64) NOT NULL ,
        prenom_formateur        Varchar (64) NOT NULL ,
        mail_formateur          Varchar (128) NOT NULL ,
        mdp_formateur           Varchar (255) NOT NULL ,
        type_contrat_formateur  Char (3) NOT NULL ,
        date_debut_contrat      Date ,
        date_fin_contrat        Date ,
        permissions_utilisateur TinyINT NOT NULL ,
        numero_grn              Int NOT NULL ,
        id_ville                Int NOT NULL
	,CONSTRAINT Formateur_PK PRIMARY KEY (id_formateur)

	,CONSTRAINT Formateur_GRN_FK FOREIGN KEY (numero_grn) REFERENCES GRN(numero_grn)
	,CONSTRAINT Formateur_Ville0_FK FOREIGN KEY (id_ville) REFERENCES Ville(id_ville)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Date_vacance
#------------------------------------------------------------

CREATE TABLE Date_vacance(
        id_vacance          Int NOT NULL ,
        date_debut_vacances Date NOT NULL ,
        date_fin_vacances   Date NOT NULL ,
        validation          Bool NOT NULL ,
        id_formateur        Int
	,CONSTRAINT Date_vacance_PK PRIMARY KEY (id_vacance)

	,CONSTRAINT Date_vacance_Formateur_FK FOREIGN KEY (id_formateur) REFERENCES Formateur(id_formateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Date_teletravail
#------------------------------------------------------------

CREATE TABLE Date_teletravail(
        id_teletravail          Int NOT NULL ,
        jour_teletravail        Date NOT NULL ,
        date_demande_changement Date NOT NULL ,
        date_prise_effet        Date ,
        validation              Bool NOT NULL ,
        id_formateur            Int
	,CONSTRAINT Date_teletravail_PK PRIMARY KEY (id_teletravail)

	,CONSTRAINT Date_teletravail_Formateur_FK FOREIGN KEY (id_formateur) REFERENCES Formateur(id_formateur)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: Formation
#------------------------------------------------------------

CREATE TABLE Formation(
        id_formation          Varchar (128)  NOT NULL ,
        acronyme_formation    Varchar (24) NOT NULL,
        description_formation Varchar (128) NOT NULL ,
        date_debut_formation  Date NOT NULL,
        date_fin_formation    Date NOT NULL,
        numero_grn            Int NOT NULL ,
        id_type_formation     Int NOT NULL ,
        id_formateur          Int NOT NULL ,
        id_ville              Int NOT NULL 
	,CONSTRAINT Formation_PK PRIMARY KEY (id_formation)

	,CONSTRAINT Formation_GRN_FK FOREIGN KEY (numero_grn) REFERENCES GRN(numero_grn)
	,CONSTRAINT Formation_Type_Formation0_FK FOREIGN KEY (id_type_formation) REFERENCES Type_Formation(id_type_formation)
	,CONSTRAINT Formation_Formateur1_FK FOREIGN KEY (id_formateur) REFERENCES Formateur(id_formateur)
	,CONSTRAINT Formation_Ville2_FK FOREIGN KEY (id_ville) REFERENCES Ville(id_ville)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Date_pae
#------------------------------------------------------------

CREATE TABLE Date_pae(
        id_date_pae    Int  Auto_increment  NOT NULL ,
        date_debut_pae Date ,
        date_fin_pae   Date ,
        id_formation   Varchar (128) NOT NULL ,
        id_formateur   Int NOT NULL
	,CONSTRAINT Date_pae_PK PRIMARY KEY (id_date_pae)

	,CONSTRAINT Date_pae_Formation_FK FOREIGN KEY (id_formation) REFERENCES Formation(id_formation)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Date_certif
#------------------------------------------------------------

CREATE TABLE Date_certif(
        id_certif         Int  Auto_increment  NOT NULL ,
        date_debut_certif Date ,
        date_fin_certif   Date ,
        id_formation      Varchar (128) NOT NULL ,
        id_formateur      Int NOT NULL
	,CONSTRAINT Date_certif_PK PRIMARY KEY (id_certif)

	,CONSTRAINT Date_certif_Formation_FK FOREIGN KEY (id_formation) REFERENCES Formation(id_formation)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Interruption
#------------------------------------------------------------

CREATE TABLE Interruption(
        id_interruption         Int  Auto_increment  NOT NULL ,
        date_debut_interruption Date ,
        date_fin_interruption   Date ,
        id_formation            Varchar (128) NOT NULL 
	,CONSTRAINT Date_interruption_PK PRIMARY KEY (id_interruption)

	,CONSTRAINT Date_interruption_Formation_FK FOREIGN KEY (id_formation) REFERENCES Formation(id_formation)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Date_ran
#------------------------------------------------------------

CREATE TABLE Date_ran(
        id_ran         Int  Auto_increment  NOT NULL ,
        date_debut_ran Date ,
        date_fin_ran   Date ,
        id_formation      Varchar (128) NOT NULL ,
        id_formateur      Int NOT NULL
	,CONSTRAINT Date_ran_PK PRIMARY KEY (id_ran)

	,CONSTRAINT Date_ran_Formation_FK FOREIGN KEY (id_formation) REFERENCES Formation(id_formation)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Date_centre
#------------------------------------------------------------

CREATE TABLE Date_centre(
        id_centre         Int  Auto_increment  NOT NULL ,
        date_debut_centre Date ,
        date_fin_centre   Date ,
        id_formation      Varchar (128) NOT NULL ,
        id_formateur      Int NOT NULL
	,CONSTRAINT Date_centre_PK PRIMARY KEY (id_centre)

	,CONSTRAINT Date_centre_Formation_FK FOREIGN KEY (id_formation) REFERENCES Formation(id_formation)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: Date_intervention
#------------------------------------------------------------

CREATE TABLE Date_intervention(
        id_intervention         Int  Auto_increment  NOT NULL ,
        date_debut_intervention Date ,
        date_fin_intervention   Date ,
        id_formateur            Int NOT NULL
	,CONSTRAINT Date_intervention_PK PRIMARY KEY (id_intervention)

	,CONSTRAINT Date_intervention_FK FOREIGN KEY (id_formateur) REFERENCES Formateur(id_formateur)
)ENGINE=InnoDB;

