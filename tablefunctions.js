// Kuukausiseuranta ei käytä näitä funktioita enää

// Rekisterin näytä asiakkaan muokkausvalikko
function editasiakas(id, solu) {

    var shownelement = document.getElementById(id + 'show2');
    shownelement.style.display = "none";

    var Form = document.forms[id + 'rek'];
    Form.elements['newvalue2'].value = solu;
    var hiddenelement = document.getElementById(id + 'hide2');
    hiddenelement.style.display = "";

    return false; // Älä päivitä sivua
}
// Rekisterin muokkausvalikon peruutus
function canceledit(id, solu) {

    var shownelement = document.getElementById(id + 'show2');
    shownelement.style.display = "";

    var hiddenelement = document.getElementById(id + 'hide2');
    hiddenelement.style.display = "none";

    return false; //Älä päivitä sivua
}
