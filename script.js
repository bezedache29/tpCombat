// Création d'un fonction permettant de d'ajouter une valeur a un display d'un ID
function accordeon(id, valeur) {
    var bloc = document.getElementById(id);
    bloc.style.display = valeur;
}

// Création d'une fonction permettant de retourner un element d'un ID
function bloc(id) {
    return document.getElementById(id);
}

// Déclaration des varaibles des boutons
var sac = document.getElementById('sac');

// Action lorsque le premier bouton est actionné
sac.onclick = function() {
    var mesItems = bloc("items");
    if(mesItems.style.display == 'block') {
        accordeon('items', 'none');
    }else {
        accordeon('items', 'block');
    }
}

