<?php

require_once("./api-get.php");
require_once("./api-post.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // http://bhologne.vvv.enseirb-matmeca.fr/api/colocations
        // http://bhologne.vvv.enseirb-matmeca.fr/api/colocation2/:id_personne
        // http://bhologne.vvv.enseirb-matmeca.fr/api/colocation/:id
        // http://bhologne.vvv.enseirb-matmeca.fr/api/personne/:id
        // http://bhologne.vvv.enseirb-matmeca.fr/api/personnes
        // http://bhologne.vvv.enseirb-matmeca.fr/api/personnes/:id_colocation
        // http://bhologne.vvv.enseirb-matmeca.fr/api/cagnottes/:id_colocation
        // http://bhologne.vvv.enseirb-matmeca.fr/api/apports/:id_cagnotte
        // http://bhologne.vvv.enseirb-matmeca.fr/api/achats/:id_colocation
        // http://bhologne.vvv.enseirb-matmeca.fr/api/sommeapport/:id_personne
        // http://bhologne.vvv.enseirb-matmeca.fr/api/versements/:id_colocation

        try {
            if (!empty($_GET['demande'])) {
                $url = explode("/", filter_var($_GET['demande'], FILTER_SANITIZE_URL));

                switch ($url[0]) {
                    case 'colocations':
                        getColocations();
                        break;

                    case 'colocation':
                        if (!empty($url[1])) {
                            getColocationById($url[1]);
                        } else {
                            throw new Exception("Vous n'avez pas renseigné l'identifiant de la colocation.");
                        }
                        break;

                    case 'personnes':
                        if (!empty($url[1])) {
                            getPersonnesByColocation($url[1]);
                        } else {
                            getPersonnes();
                        }
                        break;

                    case 'personne':
                        if (!empty($url[1])) {
                            getPersonneById($url[1]);
                        }
                        break;

                    case 'colocation2':
                        if (!empty($url[1])) {
                            getColocationByPersonne($url[1]);
                        }
                        break;

                    case 'image':
                        if (!empty($url[1])) {
                            getImageByUsername($url[1]);
                        }
                        break;

                    case 'cagnottes':
                        if (!empty($url[1])) {
                            getCagnottesByColocation($url[1]);
                        }
                        break;
                    case 'cagnotte':
                        if (!empty($url[1])) {
                            getCagnotteByPersonne($url[1]);
                        }
                        break;

                    case 'membres':
                        if (!empty($url[1])) {
                            getMembreByPersonne($url[1]);
                        }
                        break;

                    case 'apports':
                        if (!empty($url[1])) {
                            getApportsByColocation($url[1]);
                        }
                        break;

                    case 'achats':
                        if (!empty($url[1])) {
                            getAchatsByColocation($url[1]);
                        }
                        break;

                    case 'sommeapport':
                        if (!empty($url[1])) {
                            getSumApportByPersonne($url[1]);
                        }
                        break;

                    case 'versements':
                        if (!empty($url[1])) {
                            getVersementByPersonne($url[1]);
                        }
                        break;

                    case 'delversement':
                        if (!empty($url[1])) {
                            delVersementById($url[1]);
                        }
                        break;

                    default:
                        throw new Exception("La demande n'est pas valide.");
                        break;
                }
            } else {
                throw new Exception("Problème de récupération de données.");
            }
        } catch (Exception $e) {
            $erreur = array(
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            );
            print_r($erreur);
        }
        break;

    case 'POST':
        // http://bhologne.vvv.enseirb-matmeca.fr/api/colocation/?id=&name=&adresse=&id_gerant=
        // http://bhologne.vvv.enseirb-matmeca.fr/api/cagnotte/?id=&montant=&id_colocation=&nom=
        // http://bhologne.vvv.enseirb-matmeca.fr/api/adduser/?
        // http://bhologne.vvv.enseirb-matmeca.fr/api/updatecoloc/?

        try {
            if (!empty($_GET['demande'])) {
                $url = explode("/", filter_var($_GET['demande'], FILTER_SANITIZE_URL));

                switch ($url[0]) {
                    case 'colocation':
                        postColocation();
                        break;

                    case 'cagnotte':
                        postCagnotte();
                        break;

                    case 'adduser':
                        postAddUser();
                        break;

                    case 'updatecoloc':
                        updateColoc();
                        break;

                    case 'leavecoloc':
                        leaveColoc();
                        break;

                    case 'apport':
                        postApport();
                        break;

                    case 'achat':
                        postAchat();
                        break;


                    case 'updategerant':
                        postGerant();
                        break;

                    case 'delcoloc':
                        deleteColoc();
                        break;

                    case 'versement':
                        postVersement();
                        break;
                    default:
                        throw new Exception("L'envoi n'est pas valide.");
                        break;
                }
            } else {
                throw new Exception("Problème d'envoi des données.");
            }
        } catch (Exception $e) {
            $erreur = array(
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            );
            print_r($erreur);
        }
        break;
        
    default:
        # code...
        break;
}
