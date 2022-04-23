<?php
include_once("../connect.php");

function getVersementByPersonne($id_personne)
{
    $pdo = getConnexion();
    $req = "SELECT DISTINCT VERSEMENTS.* FROM VERSEMENTS
            WHERE ID_RECEVEUR=:id_personne OR ID_VERSEUR=:id_personne
            ORDER BY DATE_DE_VERSEMENT desc;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $sum = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($sum);
}

function getMembreByPersonne($id_personne)
{

    $pdo = getConnexion();
    $req = "SELECT DISTINCT PERSONNES.PRENOM_PERSONNE FROM PERSONNES
            INNER JOIN HISTORIQUES on HISTORIQUES.ID_PERSONNE=PERSONNES.ID_PERSONNE
            INNER JOIN COLOCATIONS ON HISTORIQUES.ID_COLOCATION = COLOCATIONS.ID_COLOCATION
            WHERE COLOCATIONS.ID_COLOCATION  = (
            SELECT COLOCATIONS.ID_COLOCATION FROM PERSONNES
            INNER JOIN HISTORIQUES on HISTORIQUES.ID_PERSONNE=PERSONNES.ID_PERSONNE
            INNER JOIN COLOCATIONS ON HISTORIQUES.ID_COLOCATION = COLOCATIONS.ID_COLOCATION
            WHERE PERSONNES.ID_PERSONNE = :id_personne and HISTORIQUES.DATE_DE_FIN is null)and HISTORIQUES.DATE_DE_FIN is null;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $sum = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($sum);
}

function getCagnotteByPersonne($id_personne)
{
    $pdo = getConnexion();
    $req = "SELECT CAGNOTTES.* FROM PERSONNES
            INNER JOIN HISTORIQUES ON PERSONNES.ID_PERSONNE=HISTORIQUES.ID_PERSONNE
            INNER JOIN COLOCATIONS ON COLOCATIONS.ID_COLOCATION=HISTORIQUES.ID_COLOCATION
            INNER JOIN CAGNOTTES ON CAGNOTTES.ID_COLOCATION=COLOCATIONS.ID_COLOCATION
            WHERE PERSONNES.ID_PERSONNE=:id_personne AND HISTORIQUES.DATE_DE_FIN is null;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $sum = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($sum);
}

function getSumApportByPersonne($id_personne)
{
    $pdo = getConnexion();
    $req = "SELECT SUM(APPORTS.MONTANT_APPORT) AS SUM
            from APPORTS
            WHERE APPORTS.ID_PERSONNE=:id_personne
            GROUP by APPORTS.ID_PERSONNE;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $sum = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($sum);
}

function getAchatsByColocation($id_colocation)
{

    $pdo = getConnexion();
    $req = "SELECT distinct ACHATS.* FROM COLOCATIONS
            inner join HISTORIQUES on HISTORIQUES.ID_COLOCATION = COLOCATIONS.ID_COLOCATION
            inner join PERSONNES on PERSONNES.ID_PERSONNE = HISTORIQUES.ID_PERSONNE
            inner join ACHATS on ACHATS.ID_PERSONNE = PERSONNES.ID_PERSONNE
            where COLOCATIONS.ID_COLOCATION= :id_colocation
            ORDER BY DATE_ACHAT desc;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_colocation", $id_colocation, PDO::PARAM_STR);
    $stmt->execute();
    $achats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($achats);
}

function getApportsByColocation($id_colocation)
{
    $pdo = getConnexion();
    $req = "SELECT * from APPORTS
            inner join CAGNOTTES on CAGNOTTES.ID_CAGNOTTE = APPORTS.ID_CAGNOTTE
            where CAGNOTTES.ID_COLOCATION = :id_colocation 
            ORDER BY DATE_APPORT desc;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_colocation", $id_colocation, PDO::PARAM_STR);
    $stmt->execute();
    $url = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($url);
}

function getImageByUsername($username)
{
    $pdo = getConnexion();
    $req = "SELECT URL from LOGINS 
            where USERNAME= :username ;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $url = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($url);
}

function getPersonneById($id)
{
    $pdo = getConnexion();
    $req = "SELECT * from PERSONNES 
            where ID_PERSONNE = :id";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $personne = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($personne);
}

function getCagnottesByColocation($id_colocation)
{

    $pdo = getConnexion();
    $req = "SELECT * from CAGNOTTES 
            where ID_COLOCATION = :id_colocation";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_colocation", $id_colocation, PDO::PARAM_INT);
    $stmt->execute();
    $cagnottes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($cagnottes);
}

function getPersonnes()
{
    $pdo = getConnexion();
    $req = "SELECT * from PERSONNES";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($personnes);
}

function getPersonnesByColocation($id_colocation)
{
    //Ne renvois que les occupants actuelles du au DATE_DE_FIN is null
    $pdo = getConnexion();
    $req = "SELECT * from PERSONNES 
            inner join HISTORIQUES on HISTORIQUES.ID_PERSONNE = PERSONNES.ID_PERSONNE
            where HISTORIQUES.ID_COLOCATION= :id_colocation
            and HISTORIQUES.DATE_DE_FIN is null";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_colocation", $id_colocation, PDO::PARAM_INT);
    $stmt->execute();
    $personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($personnes);
}

function getColocations()
{
    $pdo = getConnexion();
    $req = "SELECT * from COLOCATIONS";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $colocations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($colocations);
}

function getColocationById($id)
{
    $pdo = getConnexion();
    $req = "SELECT * from COLOCATIONS 
            where COLOCATIONS.ID_COLOCATION = :id";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $colocation = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($colocation);
}


function getColocationByPersonne($id_personne)
{
    $pdo = getConnexion();
    $req = "SELECT * from COLOCATIONS 
            inner join HISTORIQUES on HISTORIQUES.ID_COLOCATION=COLOCATIONS.ID_COLOCATION 
            where HISTORIQUES.ID_PERSONNE=:id_personne 
            and HISTORIQUES.DATE_DE_FIN is null";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $colocation = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($colocation);
}

function delVersementById($id_versement){
    $pdo = getConnexion();
    $req = "DELETE FROM VERSEMENTS WHERE ID_VERSEMENT=:id_versement";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_versement", $id_versement, PDO::PARAM_INT);
    $stmt->execute();
    $colocation = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    header("Location: " . $_SERVER['HTTP_REFERER']);
}



