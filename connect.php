<?php
function getConnexion(){
    return new PDO("mysql:host=localhost;dbname=colocation;charset=utf8","root","");
    //return new PDO("mysql:host=localhost;dbname=bhologne;charset=utf8","bhologne","67di72ni");
}

function sendJSON($infos)
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    echo json_encode($infos);
}

?>