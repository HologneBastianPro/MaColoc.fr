<?php
session_start();
include_once("../connect.php");

$username = $_SESSION['username'];

$pdo = getConnexion();
$req = "SELECT * 
        FROM LOGINS 
        where USERNAME='$username';";
$result = $pdo->prepare($req);
$result->execute();

if ($result->rowCount() > 0) {
    $data = $result->fetchAll();
    $req = "SELECT * 
            FROM HISTORIQUES 
            WHERE ID_PERSONNE=:id_personne AND DATE_DE_FIN is null;";
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
}


?>
