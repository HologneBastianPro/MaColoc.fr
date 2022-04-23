//url API
//var URL = 'https://bhologne.vvvpedago.enseirb-matmeca.fr/api';
var URL = 'http://localhost/api';

var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close2")[0];

/* nav bar */
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("showMenu");
    });
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

//Recuperation de la photo de profil
fetch(`${URL}/image/${username}`)
    .then(response => response.json())
    .then(data => {
        console.log(data);
        var img = document.createElement('img');
        img.src = `assets/Photos profil/${data[0].URL}`
        document.getElementsByClassName("profile-content")[0].appendChild(img);
    })
    .catch(error => alert("Erreur : " + error));