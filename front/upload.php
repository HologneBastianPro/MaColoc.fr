<?php
session_start();
include_once("../connect.php");


if(isset($_FILES['file'])){
    //Suppression de l'ancienne photo
    $username = $_SESSION['username'];
    $pdo = getConnexion();
    $req = "SELECT URL from LOGINS
            WHERE USERNAME = :username";
    $stmt = $pdo->prepare($req);    
    $stmt->bindValue(":username",$username,PDO::PARAM_STR);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $old =  $response[0]["URL"];

    if ($old != "default.png") {
        unlink('./assets/Photos profil/'.$old);
    }

    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $moved = move_uploaded_file($tmpName, './assets/Photos profil/'.$name);
    //Mise à jour de la nouvelle photo
    $username = $_SESSION['username'];
    $pdo = getConnexion();
    $req = "UPDATE LOGINS
            SET URL = :name
            WHERE USERNAME = :username";
    $stmt = $pdo->prepare($req);    
    $stmt->bindValue(":name",$name,PDO::PARAM_STR);
    $stmt->bindValue(":username",$username,PDO::PARAM_STR);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
elseif(isset($_POST['login'])){
    $username = $_SESSION['username'];
    $new_username = $_POST['login'];
    $pdo = getConnexion();
    $req = "UPDATE LOGINS
            SET USERNAME = :new_username
            WHERE USERNAME=:username";
    $stmt = $pdo->prepare($req);    
    $stmt->bindValue(":username",$username,PDO::PARAM_STR);
    $stmt->bindValue(":new_username",$new_username,PDO::PARAM_STR);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $_SESSION['username'] = $new_username;
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
elseif(isset($_POST['pass'])){
    $username = $_SESSION['username'];
    $new_pass = $_POST['pass'];
    $pdo = getConnexion();
    $req = "UPDATE LOGINS
            SET PASSWORD = :new_pass
            WHERE USERNAME=:username";
    $stmt = $pdo->prepare($req);    
    $stmt->bindValue(":username",$username,PDO::PARAM_STR);
    $stmt->bindValue(":new_pass",$new_pass,PDO::PARAM_STR);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $_SESSION['password'] = $new_pass;
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
elseif(isset($_FILES['file_coloc'])){
    $id_coloc = $_POST['id_colocation'];
    $pdo = getConnexion();
    $req = "SELECT URL 
            from COLOCATIONS
            WHERE ID_COLOCATION = :id_coloc;";
    $stmt = $pdo->prepare($req);    
    $stmt->bindValue(":id_coloc",$id_coloc,PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $old =  $response[0]["URL"];

    if ($old != "default.jpg") {
        unlink('./assets/photos_coloc/'.$old);
    }

    $tmpName = $_FILES['file_coloc']['tmp_name'];
    $name = $_FILES['file_coloc']['name'];
    $size = $_FILES['file_coloc']['size'];
    $error = $_FILES['file_coloc']['error'];
    $moved = move_uploaded_file($tmpName, './assets/photos_coloc/'.$name);
    //Mise à jour de la nouvelle photo
    $pdo = getConnexion();
    $req = "UPDATE COLOCATIONS
            SET URL = :name
            WHERE ID_COLOCATION = :id_coloc;";
    $stmt = $pdo->prepare($req);    
    $stmt->bindValue(":name",$name,PDO::PARAM_STR);
    $stmt->bindValue(":id_coloc",$id_coloc,PDO::PARAM_INT);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    header("Location: ".$_SERVER['HTTP_REFERER']);
}


?>