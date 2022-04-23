<?php
include_once("../connect.php");

function deleteColoc()
{
    $id_coloc = $_POST['id_colocation'];

    //Recuperation des ids des membres de la colocation
    $pdo = getConnexion();
    $req = "SELECT PERSONNES.ID_PERSONNE FROM PERSONNES
            INNER JOIN HISTORIQUES on HISTORIQUES.ID_PERSONNE=PERSONNES.ID_PERSONNE
            INNER JOIN COLOCATIONS ON HISTORIQUES.ID_COLOCATION = COLOCATIONS.ID_COLOCATION
            WHERE COLOCATIONS.ID_COLOCATION=:id_coloc;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_coloc", $id_coloc, PDO::PARAM_STR);
    $stmt->execute();
    $personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($personnes as $key => $val) {
        $_POST['id_personne'] =  $val['ID_PERSONNE'];
        leaveColoc();
    }
    $req = "DELETE FROM COLOCATIONS 
            WHERE ID_COLOCATION=:id_coloc;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_coloc", $id_coloc, PDO::PARAM_INT);
    $stmt->execute();
    $personnes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function postGerant()
{
    $new_gerant = $_POST['new_gerant'];
    $id_colocation = $_POST['id_colocation'];
    $pdo = getConnexion();
    $req = "SELECT PERSONNES.ID_PERSONNE FROM PERSONNES
            WHERE PERSONNES.PRENOM_PERSONNE=:new_gerant;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":new_gerant", $new_gerant, PDO::PARAM_STR);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $id_new_gerant = $response[0]['ID_PERSONNE'];
    $stmt->closeCursor();
    $req = "UPDATE COLOCATIONS 
            set ID_GERANT=:id_new_gerant 
            where ID_COLOCATION=:id_colocation";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_new_gerant", $id_new_gerant, PDO::PARAM_INT);
    $stmt->bindValue(":id_colocation", $id_colocation, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function postApport()
{
    $date = $_POST['date'];
    $id_personne = $_POST['id'];
    $id_cagnotte = $_POST['id_cagnotte'];
    $montant = $_POST['montant'];
    $pdo = getConnexion();
    $req = "INSERT into APPORTS (MONTANT_APPORT,DATE_APPORT,ID_PERSONNE,ID_CAGNOTTE) 
            VALUES (:montant,:date,:id_personne,:id_cagnotte);";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":montant", $montant, PDO::PARAM_INT);
    $stmt->bindValue(":date", $date, PDO::PARAM_STR);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->bindValue(":id_cagnotte", $id_cagnotte, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($response);
    $stmt->closeCursor();
    $req = "UPDATE CAGNOTTES 
            set MONTANT_CAGNOTTE=MONTANT_CAGNOTTE+:montant 
            where ID_CAGNOTTE=:id_cagnotte";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":montant", $montant, PDO::PARAM_INT);
    $stmt->bindValue(":id_cagnotte", $id_cagnotte, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($response);
    $stmt->closeCursor();
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function leaveColoc()
{
    $id_personne = $_POST['id_personne'];
    //Supprimeer les apports
    $pdo = getConnexion();
    $req = "DELETE FROM APPORTS 
            WHERE ID_PERSONNE=:id_personne;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();

    //Set la date de fin à l'enregistrement actuelle de Historique
    $req = "UPDATE HISTORIQUES 
            SET DATE_DE_FIN = sysdate() 
            WHERE ID_PERSONNE=:id_personne AND DATE_DE_FIN is null;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
    header("Location: " . $_SERVER['HTTP_REFERER']);
}


function updateColoc()
{
    $id_personne = $_POST['id_personne'];
    $new_coloc = $_POST['coloc'];
    //Supprimeer les apports
    $pdo = getConnexion();
    $req = "DELETE FROM APPORTS 
            WHERE ID_PERSONNE=:id_personne;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    //Set la date de fin à l'enregistrement actuelle de Historique
    $req = "UPDATE HISTORIQUES 
            SET DATE_DE_FIN = sysdate() 
            WHERE ID_PERSONNE=:id_personne AND DATE_DE_FIN is null;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    //Recuperer l'id de la nouvelle coloc
    $req = "SELECT ID_COLOCATION 
            FROM COLOCATIONS 
            WHERE NOM_COLOCATION=:new_coloc;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":new_coloc", $new_coloc, PDO::PARAM_STR);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $id_colocation = $response[0]["ID_COLOCATION"];
    //Nouvelle enregistrement historique
    $req = "INSERT INTO HISTORIQUES(DATE_DE_DEBUT,ID_PERSONNE,ID_COLOCATION) 
            values (sysdate(),:id_personne,:id_colocation);";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_personne", $id_personne, PDO::PARAM_INT);
    $stmt->bindValue(":id_colocation", $id_colocation, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function postColocation()
{
    $pdo = getConnexion();
    $name = $_POST['name'];
    $adresse = $_POST['adresse'];
    $id_gerant = $_POST['id_gerant'];
    $req = "INSERT into COLOCATIONS(NOM_COLOCATION,ADRESSE_COLOCATION,ID_GERANT,URL)
            values ( :name , :adresse , :id_gerant , 'default.jpg' ) ;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->bindValue(":adresse", $adresse, PDO::PARAM_STR);
    $stmt->bindValue(":id_gerant", $id_gerant, PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (empty($response)) {
        $_POST['id_personne'] = $id_gerant;
        $_POST['coloc'] = $name;
        echo "Colocation créee avec succés.";
        updateColoc();
        
    } else {
        sendJSON($response);
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
}



function postCagnotte()
{

    $pdo = getConnexion();
    $id_colocation = $_POST['id_coloc3'];
    $name = $_POST['nomCagnotte'];
    $req = "INSERT into CAGNOTTES(MONTANT_CAGNOTTE,ID_COLOCATION,NOM_CAGNOTTE) 
            values ( 0, :id_colocation , :name) ;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id_colocation", $id_colocation, PDO::PARAM_INT);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (empty($response)) {
            echo "Cagnotte créee avec succés.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        sendJSON($response);
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function postAddUser()
{
    //Creation Personne
    $pdo = getConnexion();
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $req = "INSERT into PERSONNES(NOM_PERSONNE,PRENOM_PERSONNE,MAIL_PERSONNE,ADRESSE_PERSONNE,TEL_PERSONNE) 
            values ( :nom , :prenom , :email, :adresse,:tel ) ;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
    $stmt->bindValue(":adresse", $adresse, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
    $last_id = $pdo->lastInsertId();
    //Creation Login
    $pdo = getConnexion();
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $req = "INSERT INTO LOGINS (USERNAME,PASSWORD,URL,ID_PERSONNE) 
            VALUES (:username,:pass,'default.png', :id_personne);";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    $stmt->bindValue(":id_personne", $last_id, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
    echo "Utilisateur crée avec succés.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function postAchat()
{
    //Creation Personne
    $pdo = getConnexion();
    $montant = $_POST['montant'];
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $id_personne = $_POST['id'];
    $id_cagnotte = $_POST['id_cagnotte'];
    $req = "INSERT into ACHATS(NOM_ACHAT,DATE_ACHAT,MONTANT_ACHAT,ID_PERSONNE,ID_CAGNOTTE) 
            values ( :nom , :date , :montant, :id,:id_cagnotte ) ;";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindValue(":date", $date, PDO::PARAM_STR);
    $stmt->bindValue(":montant", $montant, PDO::PARAM_STR);
    $stmt->bindValue(":id", $id_personne, PDO::PARAM_INT);
    $stmt->bindValue(":id_cagnotte", $id_cagnotte, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
    $req = "UPDATE CAGNOTTES 
            set MONTANT_CAGNOTTE=MONTANT_CAGNOTTE-:montant 
            where ID_CAGNOTTE=:id_cagnotte";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":montant", $montant, PDO::PARAM_INT);
    $stmt->bindValue(":id_cagnotte", $id_cagnotte, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
    echo "Achat crée avec succés.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function postVersement()
{
    $pdo = getConnexion();
    $id_envoyeur = $_POST['id_envoyeur'];
    $id_receveur = $_POST['id_receveur'];
    $montant = $_POST['montant'];
    $date = $_POST['date'];
    $req = "INSERT INTO VERSEMENTS (ID_VERSEUR,ID_RECEVEUR,MONTANT_VERSEMENT,DATE_DE_VERSEMENT) 
            values (:id_envoyeur,:id_receveur,:montant,:date);";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":montant", $montant, PDO::PARAM_INT);
    $stmt->bindValue(":id_envoyeur", $id_envoyeur, PDO::PARAM_INT);
    $stmt->bindValue(":id_receveur", $id_receveur, PDO::PARAM_INT);
    $stmt->bindValue(":date", $date, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
    echo "Versement crée avec succés.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
