-- ============================================================
    --   Nom de la base   :  COLOCATION                                          
    --   Date de creation :  05/03/2020                       
    -- ============================================================
    -- ============================================================
    --   Table : VERSEMENTS                      
    -- ============================================================
CREATE TABLE VERSEMENTS(
    ID_VERSEMENT INT(3) NOT NULL AUTO_INCREMENT,
    ID_VERSEUR INT(3) NOT NULL,
    ID_RECEVEUR INT(3) NOT NULL,
    MONTANT_VERSEMENT INT(5),
    DATE_DE_VERSEMENT DATE,
    CONSTRAINT pk_versement PRIMARY KEY(ID_VERSEMENT)
);
-- ============================================================
--   Table : PERSONNES                                       
-- ============================================================
CREATE TABLE PERSONNES(
    ID_PERSONNE INT(3) NOT NULL AUTO_INCREMENT,
    NOM_PERSONNE CHAR(50),
    PRENOM_PERSONNE CHAR(50),
    MAIL_PERSONNE CHAR(50),
    ADRESSE_PERSONNE CHAR(50),
    TEL_PERSONNE CHAR(50),
    CONSTRAINT pk_personne PRIMARY KEY(ID_PERSONNE)
);
-- ============================================================
--   Table : LOGINS                                      
-- ============================================================
CREATE TABLE LOGINS(
    ID_LOGIN INT(3) NOT NULL AUTO_INCREMENT,
    USERNAME CHAR(100),
    PASSWORD CHAR(100),
    URL CHAR(50) NOT NULL,
    ID_PERSONNE INT(3) NOT NULL,
    CONSTRAINT pk_login PRIMARY KEY(ID_LOGIN)
);
-- ============================================================
--   Table : HISTORIQUES                                              
-- ============================================================
CREATE TABLE HISTORIQUES(
    ID_HISTORIQUE INT(3) NOT NULL AUTO_INCREMENT,
    DATE_DE_DEBUT DATE,
    DATE_DE_FIN DATE,
    ID_PERSONNE INT(3) NOT NULL,
    ID_COLOCATION INT(3) NOT NULL,
    CONSTRAINT pk_historique PRIMARY KEY(ID_HISTORIQUE)
);
-- ============================================================
--   Table : COLOCATIONS                                              
-- ============================================================
CREATE TABLE COLOCATIONS(
    ID_COLOCATION INT(3) NOT NULL AUTO_INCREMENT,
    NOM_COLOCATION CHAR(50),
    ADRESSE_COLOCATION CHAR(50),
    ID_GERANT INT(3) NOT NULL UNIQUE,
    URL CHAR(50) NOT NULL,
    CONSTRAINT pk_colocation PRIMARY KEY(ID_COLOCATION)
);
-- ============================================================
--   Table : CAGNOTTES                                              
-- ============================================================
CREATE TABLE CAGNOTTES(
    ID_CAGNOTTE INT(3) NOT NULL AUTO_INCREMENT,
    MONTANT_CAGNOTTE INT(5),
    ID_COLOCATION INT(3) UNIQUE NOT NULL,
    NOM_CAGNOTTE CHAR(50),
    CONSTRAINT pk_cagnotte PRIMARY KEY(ID_CAGNOTTE)
);
-- ============================================================
--   Table : APPORTS                                              
-- ============================================================
CREATE TABLE APPORTS(
    ID_APPORT INT(3) NOT NULL AUTO_INCREMENT,
    MONTANT_APPORT INT(5),
    DATE_APPORT DATE,
    ID_PERSONNE INT(3) NOT NULL,
    ID_CAGNOTTE INT(3) NOT NULL,
    CONSTRAINT pk_apport PRIMARY KEY(ID_APPORT)
);
-- ============================================================
--   Table : ACHATS                                              
-- ============================================================
CREATE TABLE ACHATS(
    ID_ACHAT INT(3) NOT NULL AUTO_INCREMENT,
    NOM_ACHAT CHAR(50),
    DATE_ACHAT DATE,
    MONTANT_ACHAT FLOAT(5),
    ID_PERSONNE INT(3),
    ID_CAGNOTTE INT(3),
    CONSTRAINT pk_achat PRIMARY KEY(ID_ACHAT)
);
-- ============================================================
--   Table : IMPLICATION                                              
-- ============================================================
CREATE TABLE IMPLICATION(
    ID_IMPLICATION INT(3) NOT NULL AUTO_INCREMENT,
    ID_PERSONNE INT(3) NOT NULL,
    ID_ACHAT INT(3) NOT NULL,
    CONSTRAINT pk_implication PRIMARY KEY(ID_IMPLICATION)
);
-- ============================================================
--   FK                                             
-- ============================================================
ALTER TABLE
    VERSEMENTS ADD CONSTRAINT fk1_versements FOREIGN KEY(ID_VERSEUR) REFERENCES PERSONNES(ID_PERSONNE);
ALTER TABLE
    VERSEMENTS ADD CONSTRAINT fk2_versements FOREIGN KEY(ID_RECEVEUR) REFERENCES PERSONNES(ID_PERSONNE);
ALTER TABLE
    HISTORIQUES ADD CONSTRAINT fk1_historiques FOREIGN KEY(ID_COLOCATION) REFERENCES COLOCATIONS(ID_COLOCATION) ON DELETE CASCADE;
ALTER TABLE
    HISTORIQUES ADD CONSTRAINT fk2_historiques FOREIGN KEY(ID_PERSONNE) REFERENCES PERSONNES(ID_PERSONNE);
ALTER TABLE
    COLOCATIONS ADD CONSTRAINT fk1_colocation FOREIGN KEY(ID_GERANT) REFERENCES PERSONNES(ID_PERSONNE);
ALTER TABLE
    CAGNOTTES ADD CONSTRAINT fk1_cagnotte FOREIGN KEY(ID_COLOCATION) REFERENCES COLOCATIONS(ID_COLOCATION) ON DELETE CASCADE;
ALTER TABLE
    APPORTS ADD CONSTRAINT fk1_apport FOREIGN KEY(ID_PERSONNE) REFERENCES PERSONNES(ID_PERSONNE);
ALTER TABLE
    APPORTS ADD CONSTRAINT fk2_apport FOREIGN KEY(ID_CAGNOTTE) REFERENCES CAGNOTTES(ID_CAGNOTTE) ON DELETE CASCADE;
ALTER TABLE
    ACHATS ADD CONSTRAINT fk1_achat FOREIGN KEY(ID_PERSONNE) REFERENCES PERSONNES(ID_PERSONNE);
ALTER TABLE
    ACHATS ADD CONSTRAINT fk2_achat FOREIGN KEY(ID_CAGNOTTE) REFERENCES CAGNOTTES(ID_CAGNOTTE) ON DELETE CASCADE;;
ALTER TABLE
    IMPLICATION ADD CONSTRAINT fk1_implication FOREIGN KEY(ID_PERSONNE) REFERENCES PERSONNES(ID_PERSONNE);
ALTER TABLE
    IMPLICATION ADD CONSTRAINT fk2_implication FOREIGN KEY(ID_ACHAT) REFERENCES ACHATS(ID_ACHAT);
ALTER TABLE
    LOGINS ADD CONSTRAINT fk1_login FOREIGN KEY(ID_PERSONNE) REFERENCES PERSONNES(ID_PERSONNE);
