//url API
//var URL = 'https://bhologne.vvvpedago.enseirb-matmeca.fr/api';
var URL = 'http://localhost/api';


modal1 = document.getElementById("apportModal");
modal2 = document.getElementById("cagnotteModal");
modal3 = document.getElementById("achatModal");
var span = document.getElementsByClassName("close2")[0];
var spanCagnotte = document.getElementsByClassName("close2")[2];
var spanAchat = document.getElementsByClassName("close2")[1];

// Modal ajouter cagnotte
addCagnotte.onclick = function() {
    modal2.style.display = "block";
}
spanCagnotte.onclick = function() {
    modal2.style.display = "none";
}

// Modal ajouter apport
addApport.onclick = function() {
    modal1.style.display = "block";
}
span.onclick = function() {
    modal1.style.display = "none";
}

// Modal ajouter achat
addAchat.onclick = function() {
    modal3.style.display = "block";
}
spanAchat.onclick = function() {
    modal3.style.display = "none";
}

//Close modals
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
}

// ---------------------------- Infos Générales ----------------------------------- //

divGeneraleG = document.getElementById('part-G-generale');
divGeneraleDG = document.getElementById('part-DG-generale');
divGeneraleDDH = document.getElementById('part-DDH-generale');
divGeneraleDDB = document.getElementById('part-DDB-generale');

//Ah terme id recuperer grace au session

fetch(`${URL}/colocation2/${id_personne}`)
    .then(response => response.json())
    .then(data => {
        var nom = document.createElement('h1');
        nom.classList = "element-part";
        nom.innerHTML = data[0].NOM_COLOCATION;
        divGeneraleDDH.appendChild(nom);

        var img = document.createElement('img');
        img.src = `assets/photos_coloc/${data[0].URL}`
        divGeneraleG.appendChild(img);

        var adresse = document.createElement('h1');
        adresse.classList = "element-part";
        adresse.innerHTML = data[0].ADRESSE_COLOCATION;
        divGeneraleDDH.appendChild(adresse);

        fetch(`${URL}/personne/${data[0].ID_GERANT}`)
            .then(response2 => response2.json())
            .then(data2 => {
                var gerant = document.createElement('h1');
                gerant.classList = "element-part";
                gerant.innerHTML = data2[0].PRENOM_PERSONNE + ' ' + data2[0].NOM_PERSONNE;

                var gerant2 = document.createElement('h1');
                gerant2.classList = "element-part";
                gerant2.innerHTML = data2[0].PRENOM_PERSONNE + ' ' + data2[0].NOM_PERSONNE;

                divGeneraleDDH.appendChild(gerant);
                divCagnotteDDH.appendChild(gerant2);
            })
            .catch(error => alert("Erreur : " + error));

        fetch(`${URL}/personnes/${data[0].ID_COLOCATION}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(element => {
                    var nom2 = document.createElement('h1');
                    nom2.classList = "element-part-membre";
                    nom2.innerHTML = element.PRENOM_PERSONNE + ' ' + element.NOM_PERSONNE;
                    divGeneraleDDB.appendChild(nom2);
                });
            })
            .catch(error => alert("Erreur : " + error));
    })
    .catch(error => alert("Erreur : " + error));


// ---------------------------- Infos cagnotte ----------------------------------- //

var cagnotteG = document.getElementById("part-G-cagnotte");
var cagnotteD = document.getElementById("part-D-cagnotte");
var apport = document.getElementById('apport');
var achat = document.getElementById('achat');
var divCagnotteDDH = document.getElementById('part-DDH-cagnotte');
var divCagnotteDDB = document.getElementById('part-DDB-cagnotte');


fetch(`${URL}/cagnotte/${id_personne}`)
    .then(response => response.json())
    .then(data => {
        //Si la coloc n'a pas de cagnotte
        if (data.length == 0) {
            //Gérer les display
            cagnotteG.style.display = "none"
            cagnotteD.style.display = "none"
            achat.style.display = "none";
            apport.style.display = "none";
            nonCagnotte.style.display = "block";
            if (`${role}` != "Gerant coloc") {
                addCagnotte.style.display = "none";
            }
        }
        //Si la coloc a une cagnotte
        else {
            //Gérer les display
            cagnotteG.style.display = "block"
            cagnotteD.style.display = "block"
            achat.style.display = "block";
            apport.style.display = "block";
            nonCagnotte.style.display = "none";

            var nom = document.createElement('h1');
            nom.classList = "element-part";
            nom.innerHTML = data[0].NOM_CAGNOTTE;
            divCagnotteDDH.appendChild(nom);

            var solde = document.createElement('h1');
            solde.classList = "soldeinf100";
            solde.innerHTML = data[0].MONTANT_CAGNOTTE + "€";
            if (parseInt(data[0].MONTANT_CAGNOTTE) > 100) {
                solde.classList = "soldesup100";
            }
            divCagnotteDDB.appendChild(solde);

            // Highcharts diagramme
            var ret = Highcharts.chart('container', {
                chart: {
                    backgroundColor: null,
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: 'Montant total des apports ',
                    data: []
                }]
            });

            var btnhide = document.getElementsByClassName("highcharts-button-symbol")[0];
            var credithide = document.getElementsByClassName("highcharts-credits")[0];
            btnhide.style.display = "none";
            credithide.style.display = "none"; // /!\ Pour des raisons ergonomiques nous cachons le crédit mais le code est issu de highchart /!\

            //Ajouter data diagramme
            fetch(`${URL}/colocation2/${id_personne}`)
                .then(response => response.json())
                .then(data => {
                    fetch(`${URL}/personnes/${data[0].ID_COLOCATION}`)
                        .then(response => response.json())
                        .then(data2 => {
                            data2.forEach(element => {
                                var nom2 = document.createElement('h1');
                                nom2.innerHTML = element.PRENOM_PERSONNE + ' ' + element.NOM_PERSONNE;
                                //Montant apports
                                fetch(`${URL}/sommeapport/${element.ID_PERSONNE}`)
                                    .then(response => response.json())
                                    .then(data3 => {
                                        if (typeof(data3[0]) != "undefined") {
                                            var montant = data3[0].SUM;
                                            ret.series[0].addPoint([nom2.innerHTML, parseInt(montant)]);
                                        }
                                    })
                                    .catch(error => alert("Erreur : " + error));
                            })
                        })
                        .catch(error => alert("Erreur : " + error));
                })
                .catch(error => alert("Erreur : " + error));
        }
    })
    .catch(error => alert("Erreur : " + error));

// ---------------------------- Les apports ----------------------------------- //

tabApport = document.getElementById('infoTab');

//Remplir le tableau apports
fetch(`${URL}/colocation2/${id_personne}`)
    .then(response => response.json())
    .then(data => {
        fetch(`${URL}/apports/${data[0].ID_COLOCATION}`)
            .then(response => response.json())
            .then(data2 => {
                data2.forEach(element => {
                    //Créer nouvelle ligne
                    var ligne = document.createElement('tr');
                    tabApport.appendChild(ligne);

                    fetch(`${URL}/personne/${element.ID_PERSONNE}`)
                        .then(response => response.json())
                        .then(data3 => {
                            //Ajouter la personne
                            if (typeof(data3[0]) != "undefined") {
                                var cellPersonne = document.createElement('td');
                                cellPersonne.innerHTML = data3[0].PRENOM_PERSONNE + ' ' + data3[0].NOM_PERSONNE;
                                ligne.appendChild(cellPersonne);
                            }
                        })
                        .catch(error => alert("Erreur : " + error));

                    //Ajouter la date
                    var cellDate = document.createElement('td');
                    cellDate.innerHTML = element.DATE_APPORT;
                    ligne.appendChild(cellDate);

                    //Ajouter le montant
                    var cellMontant = document.createElement('td');
                    cellMontant.innerHTML = element.MONTANT_APPORT;
                    ligne.appendChild(cellMontant);
                })
            })
            .catch(error => alert("Erreur : " + error));
    })
    .catch(error => alert("Erreur : " + error));

//Ajouter Apport
fetch(`${URL}/personne/${id_personne}`)
    .then(response => response.json())
    .then(data => {
        //retourne la personne
        var personne = document.getElementById("add_apport_info_personne")
        personne.value = data[0].PRENOM_PERSONNE + ' ' + data[0].NOM_PERSONNE;
    })
    .catch(error => alert("Erreur : " + error));

fetch(`${URL}/colocation2/${id_personne}`)
    .then(response => response.json())
    .then(data => {
        fetch(`${URL}/cagnottes/${data[0].ID_COLOCATION}`)
            .then(response => response.json())
            .then(data2 => {
                //retourne l'id-cagnotte
                if (data2.length != 0) {
                    var idcagnotte = document.getElementById("add_info_cagnotte")
                    idcagnotte.value = data2[0].ID_CAGNOTTE;
                }
            })
            .catch(error => alert("Erreur : " + error));
    })
    .catch(error => alert("Erreur : " + error));


// ---------------------------- Les achats ----------------------------------- //

tabAchats = document.getElementById('infoTabAchat');

//Remplir le tableau achat
fetch(`${URL}/colocation2/${id_personne}`)
    .then(response => response.json())
    .then(data => {

        fetch(`${URL}/achats/${data[0].ID_COLOCATION}`)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                data2.forEach(element => {
                    //Créer nouvelle ligne
                    var ligne = document.createElement('tr');
                    tabAchats.appendChild(ligne);

                    //Ajouter l'intitulé
                    var cellIntitule = document.createElement('td');
                    cellIntitule.innerHTML = element.NOM_ACHAT;
                    ligne.appendChild(cellIntitule);

                    fetch(`${URL}/personne/${element.ID_PERSONNE}`)
                        .then(response => response.json())
                        .then(data3 => {
                            //Ajouter la personne
                            if (typeof(data3[0]) != "undefined") {
                                var cellPersonne = document.createElement('td');
                                cellPersonne.innerHTML = data3[0].PRENOM_PERSONNE + ' ' + data3[0].NOM_PERSONNE;
                                ligne.appendChild(cellPersonne);
                            }
                        })
                        .catch(error => alert("Erreur : " + error));

                    //Ajouter la date
                    var cellDate = document.createElement('td');
                    cellDate.innerHTML = element.DATE_ACHAT;
                    ligne.appendChild(cellDate);

                    //Ajouter le montant
                    var cellMontant = document.createElement('td');
                    cellMontant.innerHTML = element.MONTANT_ACHAT;
                    ligne.appendChild(cellMontant);
                })
            })
            .catch(error => alert("Erreur : " + error));
    })
    .catch(error => alert("Erreur : " + error));

//Ajouter Achat
fetch(`${URL}/personne/${id_personne}`)
    .then(response => response.json())
    .then(data => {
        //retourne la personne
        var personne = document.getElementById("add_achat_info_personne")
        personne.value = data[0].PRENOM_PERSONNE + ' ' + data[0].NOM_PERSONNE;
    })
    .catch(error => alert("Erreur : " + error));

fetch(`${URL}/colocation2/${id_personne}`)
    .then(response => response.json())
    .then(data => {
        fetch(`${URL}/cagnottes/${data[0].ID_COLOCATION}`)
            .then(response => response.json())
            .then(data2 => {
                //retourne l'id-cagnotte
                if (data2.length != 0) {
                    var idcagnotte = document.getElementById("add_info_cagnotte_achat")
                    idcagnotte.value = data2[0].ID_CAGNOTTE;
                }
            })
            .catch(error => alert("Erreur : " + error));
    })
    .catch(error => alert("Erreur : " + error));


// ---------------------------- Nommer Gérant ----------------------------------- //


// SELECT personne pour nomer gérant

if (`${role}` == "Gerant coloc") {
    var select = document.getElementById("select_personne");
    var element = document.createElement('OPTION');
    fetch(`${URL}/membres/${id_personne}`)
        .then(response => {
            return response.json()
        })
        .then(data => {
            data.forEach(coloc => {
                var element = document.createElement('OPTION');
                element.innerHTML = coloc.PRENOM_PERSONNE;
                select.appendChild(element);
            })
        })

    fetch(`${URL}/colocation2/${id_personne}`)
        .then(response => response.json())
        .then(data => {
            idcoloc = document.getElementById('add_info_idcoloc');
            idcoloc.value = data[0].ID_COLOCATION;
            idcoloc2 = document.getElementById('add_info_idcoloc2');
            idcoloc2.value = data[0].ID_COLOCATION;
            idcoloc3 = document.getElementById('add_info_idcoloc3');
            idcoloc3.value = data[0].ID_COLOCATION;
            idcoloc4 = document.getElementById('add_info_idcoloc4');
            idcoloc4.value = data[0].ID_COLOCATION;
        })
        .catch(error => alert("Erreur : " + error));

} else {
    var gestionColoc = document.getElementById("gestionColoc");
    gestionColoc.style.display = "none";
}