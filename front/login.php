<?php
session_start();
include_once("../connect.php");
$url = "http://localhost/front/";


if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $_SESSION['password'] = $pass;
    $pdo = getConnexion();
    $req = "SELECT * 
            FROM LOGINS 
            where USERNAME='$username';";
    $result = $pdo->prepare($req);
    $result->execute();

    if ($result->rowCount() > 0) {
        $data = $result->fetchAll();
        
        if ($pass == $data[0]['PASSWORD']) {
            $_SESSION['username'] = $username;
            $pdo = getConnexion();
            $req = "SELECT ID_PERSONNE 
                    from LOGINS
                    WHERE USERNAME = :username";
            $stmt = $pdo->prepare($req);
            $stmt->bindValue(":username", $username, PDO::PARAM_STR);
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $_SESSION['id_personne'] =  $response[0]["ID_PERSONNE"];
            $req = "SELECT * 
                    FROM HISTORIQUES 
                    WHERE ID_PERSONNE=:id_personne";
            $stmt = $pdo->prepare($req);
            $stmt->bindValue(":id_personne", $_SESSION['id_personne'], PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            if (count($response) === 0) {
                $_SESSION['role'] = "Sans coloc";
            } else {
                $req = "SELECT * 
                        FROM COLOCATIONS 
                        WHERE ID_GERANT=:id_personne";
                $stmt = $pdo->prepare($req);
                $stmt->bindValue(":id_personne", $_SESSION['id_personne'], PDO::PARAM_INT);
                $stmt->execute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                if (count($response) === 0) {
                    $_SESSION['role'] = "Membre coloc";
                } else {
                    $_SESSION['role'] = "Gerant coloc";
                }
            }
            header("Location: " . $url . "index.php");
        } else {
            header("Location: " . $url . "index.php");
        }
    }else{
        $_SESSION['Error']="Username ou mot de passe incorrect";
        header("Location: " . $url . "index.php");
       
    }
}


