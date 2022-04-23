modal1 = document.getElementById("loginModal");
modal2 = document.getElementById("mdpModal");
modal4 = document.getElementById("versementModal");
var span = document.getElementsByClassName("close2")[0];
var spanMdp = document.getElementsByClassName("close2")[1];
var spanVersement = document.getElementsByClassName("close2")[2];

// Modal ajouter versement
addVersement.onclick = function () {
    modal4.style.display = "block";
}
spanVersement.onclick = function () {
    modal4.style.display = "none";
}

// Modal modifier mdp
modifierMDP.onclick = function () {
    modal2.style.display = "block";
}
spanMdp.onclick = function () {
    modal2.style.display = "none";
}

// Modal modifier login
modifier.onclick = function () {
    modal1.style.display = "block";
}
span.onclick = function () {
    modal1.style.display = "none";
}

//Close modals
window.onclick = function (event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
    if (event.target == modal4) {
        modal4.style.display = "none";
    }
}

//Enum les colocs pour les rejoindre
var select = document.getElementById("select");
var element = document.createElement('OPTION');
fetch(`${URL}/colocations`).then(response => {
    return response.json()
})
    .then(data => {
        data.forEach(coloc => {
            var element = document.createElement('OPTION');
            element.innerHTML = coloc.NOM_COLOCATION;
            select.appendChild(element);
        })
    })


//Cacher le mot de passe affichage
var mdp = `${password}`;
var len = mdp.length;
var mdpCache = document.getElementById("mdpCache")
mdpCache.innerHTML = "";

for (let i = 0; i < len - 2; i++) {
    mdpCache.innerHTML = mdpCache.innerHTML + "*";
}
for (let i = len - 2; i < len; i++) {
    mdpCache.innerHTML = mdpCache.innerHTML + mdp.charAt(i);
}

//Confirmer mdp
function validate() {
    var a = document.getElementById("change_pass").value;
    var b = document.getElementById("change_pass2").value;

    if (a != b) {
        alert("Les mots de passe ne correspondent pas.");
        return false;
    } else {
        alert("Le mot de passe a bien été modifié !");
        return true;
    }
}

//Cacher les onglets de coloc si pas de coloc
var coloc = document.getElementById('coloc')
var changer = document.getElementById('changer')
var rejoindre = document.getElementById('rejoindre')
if (`${role}` == "Sans coloc") {
    coloc.style.display = "none";
    changer.style.display = "none";
    rejoindre.style.display = "block";
}

// ---------------------------- Les versements ----------------------------------- //

tabVersement = document.getElementById('infoTabVersement');

//Remplir le tableau versement

fetch(`${URL}/versements/${id_personne}`)
    .then(response => response.json())
    .then(data2 => {
        data2.forEach(element => {
            //Créer nouvelle ligne
            var ligne = document.createElement('tr');
            tabVersement.appendChild(ligne);

            //Ajouter la date
            var cellDateV = document.createElement('td');
            cellDateV.innerHTML = element.DATE_DE_VERSEMENT;
            ligne.appendChild(cellDateV);

            //Ajouter le montant
            var cellMontantV = document.createElement('td');
            cellMontantV.innerHTML = element.MONTANT_VERSEMENT;
            ligne.appendChild(cellMontantV);

            //Ajouter l'envoyeur
            fetch(`${URL}/personne/${element.ID_VERSEUR}`)
                .then(response => response.json())
                .then(data3 => {
                    if (typeof (data3[0]) != "undefined") {
                        var cellEnvoyeur = document.createElement('td');
                        cellEnvoyeur.innerHTML = data3[0].PRENOM_PERSONNE + ' ' + data3[0].NOM_PERSONNE;
                        ligne.appendChild(cellEnvoyeur);
                    }
                })
                .catch(error => alert("Erreur : " + error));

            //Ajouter receveur
            fetch(`${URL}/colocation2/${id_personne}`)
                .then(response => response.json())
                .then(data3 => {
                    fetch(`${URL}/personne/${element.ID_RECEVEUR}`)
                        .then(response => response.json())
                        .then(data3 => {
                            fetch(`${URL}/personne/${element.ID_RECEVEUR}`)
                                .then(response => response.json())
                                .then(data3 => {
                                    if (typeof (data3[0]) != "undefined") {
                                        var cellReceveur = document.createElement('td');
                                        cellReceveur.innerHTML = data3[0].PRENOM_PERSONNE + ' ' + data3[0].NOM_PERSONNE;
                                        ligne.appendChild(cellReceveur);
                                    }

                                    //Ajouter bouton suppression
                                    var cellSupprimer = document.createElement('td');
                                    ligne.appendChild(cellSupprimer);
                                    var delBtn = document.createElement('button');
                                    delBtn.onclick = function () {
                                        window.location.href = URL + "/delversement/" + data2[0].ID_VERSEMENT;
                                    }
                                    delBtn.innerHTML = "Supprimer";
                                    delBtn.classList = "btnSupprVersement"
                                    cellSupprimer.appendChild(delBtn);

                                })
                                .catch(error => alert("Erreur : " + error));
                        })
                        .catch(error => alert("Erreur : " + error));
                })
                .catch(error => alert("Erreur : " + error));


        })
    })
    .catch(error => alert("Erreur : " + error));



if (role != 'Sans coloc') {

    addVersement.style.display='block';

    //Ajouter Versement
    fetch(`${URL}/personne/${id_personne}`)
        .then(response => response.json())
        .then(data => {
            //retourne l'envoyeur
            var envoyeur = document.getElementById("add_versement_info_personne")
            envoyeur.value = data[0].PRENOM_PERSONNE + ' ' + data[0].NOM_PERSONNE;
        })
        .catch(error => alert("Erreur : " + error));

    //retourne les autres membres pour receveur
    var selectMembre = document.getElementById("select_membre");
    var element = document.createElement('OPTION');
    fetch(`${URL}/membres/${id_personne}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(coloc => {
                var element = document.createElement('OPTION');
                element.innerHTML = coloc.PRENOM_PERSONNE
                selectMembre.appendChild(element);
            })
        })
        .catch(error => alert("Erreur : " + error));


    //calcule ID_receveur
    fetch(`${URL}/colocation2/${id_personne}`)
        .then(response => response.json())
        .then(data => {
            fetch(`${URL}/personnes/${data[0].ID_COLOCATION}`)
                .then(response => response.json())
                .then(data2 => {
                    data2.forEach(personne => {
                        var element = document.getElementById('add_versement_idr');
                        var object = document.forms['form_add_versement'].receveur;
                        var index = object.selectedIndex;
                        var content = object.options[index].text;
                        if (personne.PRENOM_PERSONNE == content) {
                            element.value = personne.ID_PERSONNE;
                        }
                    })
                })
                .catch(error => alert("Erreur : " + error));
        })
        .catch(error => alert("Erreur : " + error));

    //recalcule id receveur quand selection change
    function changeFunc() {

        fetch(`${URL}/colocation2/${id_personne}`)
            .then(response => response.json())
            .then(data => {
                fetch(`${URL}/personnes/${data[0].ID_COLOCATION}`)
                    .then(response => response.json())
                    .then(data2 => {
                        data2.forEach(personne => {
                            var element = document.getElementById('add_versement_idr');
                            var object = document.forms['form_add_versement'].receveur;
                            var index = object.selectedIndex;
                            var content = object.options[index].text;
                            if (personne.PRENOM_PERSONNE == content) {
                                element.value = personne.ID_PERSONNE;
                                console.log(element.value);
                            }
                        })
                    })
                    .catch(error => alert("Erreur : " + error));
            })
            .catch(error => alert("Erreur : " + error));
    }
}else{
    addVersement.style.display='none';
}
