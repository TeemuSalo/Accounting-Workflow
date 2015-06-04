// Kuukausiseuranta näytä asiakkaan muokkausvalikko
function editkausi(id, solu) {

    var shownelement = document.getElementById(id + 'show1');
    shownelement.style.display = "none";

    var Form = document.forms[id + 'seuranta'];
    Form.elements['newvalue1'].value = solu;
    var hiddenelement = document.getElementById(id + 'hide1');
    hiddenelement.style.display = "";

    return false;
}
// Kuukausiseuranta muokkausvalikon peruutus
function canceleditkausi(id, solu) {

    var shownelement = document.getElementById(id + 'show1');
    shownelement.style.display = "";

    var hiddenelement = document.getElementById(id + 'hide1');
    hiddenelement.style.display = "none";

return false;
}

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