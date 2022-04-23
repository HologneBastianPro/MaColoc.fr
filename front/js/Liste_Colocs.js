//url API
//var URL = 'https://bhologne.vvvpedago.enseirb-matmeca.fr/api';
var URL = 'http://localhost/api';

var modal = document.getElementById("myModal");

/* Modal */
function clearModal() {
    document.getElementById("modal-content").innerHTML = "";
    var modal_titre = document.createElement('div');
    modal_titre.id = 'modal_titre';
    document.getElementById("modal-content").appendChild(modal_titre);
}

function loadModal(id) {
    clearModal();
    const modal_left = document.createElement('div');
    modal_left.id = 'modal_summary';
    document.getElementById("modal-content").appendChild(modal_left);
    const modal_gerant = document.createElement('div');
    modal_gerant.id = 'modal_personnes_gerant';
    document.getElementById("modal-content").appendChild(modal_gerant);
    const modal_membres = document.createElement('div');
    modal_membres.id = 'modal_personnes_membres';
    document.getElementById("modal-content").appendChild(modal_membres);
    document.getElementById("modal_personnes_gerant").innerHTML = "Gérant :";
    document.getElementById("modal_personnes_membres").innerHTML = "Membres :";

    //modal
    fetch(`${URL}/colocation/${id}`)
        .then(response => response.json()) //Recupère la data de réponse et la met au format jsoon
        .then(data => {

            var nom = document.createElement('h1')
            nom.innerHTML = data[0].NOM_COLOCATION
            console.log(document.getElementById("modal_titre"));
            document.getElementById("modal_titre").appendChild(nom)

            const top_div = document.createElement('div');
            var img = document.createElement('img');
            img.setAttribute('class', 'img_modal');
            img.src = `assets/photos_coloc/${data[0].URL}`;
            document.getElementById("modal_summary").appendChild(img);

            var adresse = document.createElement('p')
            adresse.setAttribute('class', 'adresse_modal');
            adresse.innerHTML = data[0].ADRESSE_COLOCATION
            document.getElementById("modal_summary").appendChild(adresse)

            fetch(`${URL}/personne/${data[0].ID_GERANT}`)
                .then(response2 => response2.json()) //Recupère la data de réponse et la met au format jsoon
                .then(data2 => {
                    console.log(data2[0].NOM_PERSONNE);
                    var gerant = document.createElement('h2');
                    gerant.innerHTML = data2[0].PRENOM_PERSONNE + ' ' + data2[0].NOM_PERSONNE;
                    document.getElementById("modal_personnes_gerant").appendChild(gerant);
                })
        })
        .catch(error => alert("Erreur : " + error));

    //infos personnes
    fetch(`${URL}/personnes/${id}`)
        .then(response => response.json()) //Recupère la data de réponse et la met au format jsoon
        .then(data => {
            data.forEach(element => {
                console.log(element);
                var nom = document.createElement('h2');
                nom.innerHTML = element.PRENOM_PERSONNE + ' ' + element.NOM_PERSONNE;
                document.getElementById("modal_personnes_membres").appendChild(nom);
            });
        })
        .catch(error => alert("Erreur : " + error));
}

/* liste + search bar */

app = document.getElementById('root');

const top_div = document.createElement('div');
const input = document.createElement('input');
input.setAttribute('id', 'search-bar');
input.setAttribute('class', 'search-bar');
input.type = "text";
input.placeholder = "Filtrer par nom ...";

container = document.createElement('div');
container.setAttribute('class', 'container');

app.appendChild(input);
app.appendChild(container);

const card = document.createElement('div');
card.setAttribute('class', 'card');
const h1 = document.createElement('h1');

h1.setAttribute('class', 'title', 'titleAdd');
h1.textContent = "Ajouter une Colocation";
const button = document.createElement('button');
button.id = "btn_home";
button.classList = "button2";
button.textContent = "Cliquez ici";
container.appendChild(card);
card.appendChild(h1);
card.appendChild(button);

let tabid = new Array(20);
fetch(`${URL}/colocations`).then(response => {
        return response.json()
    })
    .then(data => {
        let j = 0;
        data.forEach(coloc => {
            const card = document.createElement('div');
            card.setAttribute('class', 'card');

            const h1 = document.createElement('h1');
            h1.style.background = `no-repeat center/120% url(\"assets/photos_coloc/${coloc.URL}\")`;

            h1.setAttribute('class', 'title');
            h1.textContent = coloc.NOM_COLOCATION;

            const p = document.createElement('p');
            p.textContent = coloc.ADRESSE_COLOCATION
            p.setAttribute('class', 'adresse');

            const detail = document.createElement('button');
            detail.setAttribute('class', 'details');
            detail.textContent = 'Détails'

            container.appendChild(card);
            card.appendChild(h1);
            card.appendChild(p);
            card.appendChild(detail);
            tabid[j] = coloc.ID_COLOCATION;
            j++;
        })
    })

.then(response => {

        for (let [index, value] of document.querySelectorAll(".details").entries()) {
            value.onclick = function() {
                loadModal(tabid[index]);
                modal.style.display = "block";
            }
        }

    })
    .catch(error => alert("Erreur : " + error));

var span = document.getElementsByClassName("close2")[0];

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

//Rechercher coloc
input.onkeyup = function() {

    let search = document.getElementById("search-bar").value;
    let card = document.getElementsByClassName("card");
    search = search.toLowerCase();

    let t = document.getElementsByClassName("title");

    for (let k = 1; k < t.length; k++) {
        if (!(t[k].innerHTML.toLowerCase().includes(search))) {
            card[k].style.display = "none";
        } else {
            card[k].style.display = "block";
        }
    }
}

//Modal ajouter une coloc
btn_home.onclick = function() {
    loadModalAdd();
    modal.style.display = "block";
}

function loadModalAdd() {
    clearModal();
    const modalContent = document.getElementById("modal-content");

    var nom = document.createElement('h1')
    nom.innerHTML = "Formulaire de création"
    console.log(document.getElementById("modal_titre"));
    document.getElementById("modal_titre").appendChild(nom)

    if (role != "Sans coloc") {
        var err = document.createElement('p');
        err.classList = "messageErreur"
        err.innerHTML = "/!\\ Vous ne pouvez pas ajouter de colocation en étant déjà membre d'une autre colocation ! /!\\";
        modalContent.appendChild(err);
    } else {
        var form = document.createElement('form');
        form.method = "POST";
        form.action = "http://localhost/api/colocation";
        modalContent.appendChild(form)

        var nomColocAdd = document.createElement('div');
        nomColocAdd.classList = "add_cagnotte_info";
        form.appendChild(nomColocAdd);
        var namec_label = document.createElement('label');
        namec_label.textContent = "Nom de la colocation :  "
        var namec = document.createElement('input');
        namec.placeholder = "Nom";
        namec.classList = "infoNom";
        namec.type = 'text';
        namec.name = 'name';
        namec.required="Ce champs doit être rempli";
        nomColocAdd.appendChild(namec_label);
        nomColocAdd.appendChild(namec);

        var idGerantColocAdd = document.createElement('div');
        idGerantColocAdd.classList = "add_cagnotte_info_id";
        form.appendChild(idGerantColocAdd);
        var id_gerant_label = document.createElement('label');
        id_gerant_label.textContent = "ID gérant colocation :  "
        var id_gerant = document.createElement('input');
        id_gerant.value = `${id_personne}`;
        id_gerant.type = 'number';
        id_gerant.name = 'id_gerant';
        idGerantColocAdd.appendChild(id_gerant_label);
        idGerantColocAdd.appendChild(id_gerant);

        var adresseColocAdd = document.createElement('div');
        adresseColocAdd.classList = "add_cagnotte_info";
        form.appendChild(adresseColocAdd);
        var adresse_label = document.createElement('label');
        adresse_label.textContent = "Adresse de la colocation :  "
        var adresse = document.createElement('input');
        adresse.placeholder = "Adresse";
        adresse.classList = "infoAdresse";
        adresse.type = 'text';
        adresse.name = 'adresse';
        adresse.required="Ce champs doit être rempli";
        adresseColocAdd.appendChild(adresse_label);
        adresseColocAdd.appendChild(adresse);

        var submit = document.createElement('input');
        submit.type = 'submit';
        submit.classList = "addColoc"
        form.appendChild(submit);
    }
}