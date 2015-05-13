function kittana() {

    //myyntilaskut
    document.getElementById("myyntilaskut").value = 10;
    document.getElementById("myyntilaskutteksti").innerHTML = "10 myyntilaskua / kk";
    //ostolaskut
    document.getElementById("ostolaskut").value = 10;
    document.getElementById("ostolaskutteksti").innerHTML = "10 ostolaskua / kk";
    //käteismaksut
    document.getElementById("käteismaksut").value = 10;
    document.getElementById("kätmaks").innerHTML = "10 käteiskuittia / kk";
    //korttimaksut
    document.getElementById("korttimaksut").value = 10;
    document.getElementById("pmaks").innerHTML = "10 korttimaksua / kk";
    //palkka
    document.getElementById("palkkabox").className = "smallboxes";
    document.getElementById("palkkabox").innerHTML = "Ei palkanlaskentaa valittu";
    document.getElementById("tuntipalkka").value = 0;
    document.getElementById("palkkah").innerHTML = "Ei palkanmaksua valittu";
    document.getElementById("kkpalkka").value = 0;
    document.getElementById("palkkakk").innerHTML = "Ei palkanmaksua valittu";
    //projekti ja kustanns
    document.getElementById("seuranta1").className = "smallbuttonsactivated";
    document.getElementById("seuranta2").className = "smallbuttons";
    document.getElementById("seuranta3").className = "smallbuttons";
    //Konsultointi ja talouspalaverit
    document.getElementById("firstline").innerHTML = "Kittana valittu";
    document.getElementById("secondline").innerHTML = "Talouspalavereja vuodessa 1-2kpl";
    document.getElementById("thirdline").innerHTML = "Konsultointi tarvittaessa";

}

function navakka() {

    //myyntilaskut
    document.getElementById("myyntilaskut").value = 50;
    document.getElementById("myyntilaskutteksti").innerHTML = "50 myyntilaskua / kk";
    //ostolaskut
    document.getElementById("ostolaskut").value = 50;
    document.getElementById("ostolaskutteksti").innerHTML = "50 ostolaskua / kk";
    //käteismaksut
    document.getElementById("käteismaksut").value = 25;
    document.getElementById("kätmaks").innerHTML = "25 käteiskuittia / kk";
    //korttimaksut
    document.getElementById("korttimaksut").value = 25;
    document.getElementById("pmaks").innerHTML = "25 korttimaksua / kk";
    //palkka
    document.getElementById("palkkabox").className = "smallboxesactivated";
    document.getElementById("palkkabox").innerHTML = "Palkanlaskenta valittu";
    document.getElementById("tuntipalkka").value = 5;
    document.getElementById("palkkah").innerHTML = "5 tuntipalkkaa";
    document.getElementById("kkpalkka").value = 5;
    document.getElementById("palkkakk").innerHTML = "5 kuukausipalkkaa";
    //projekti ja kustanns
    document.getElementById("seuranta2").className = "smallbuttonsactivated";
    document.getElementById("seuranta1").className = "smallbuttons";
    document.getElementById("seuranta3").className = "smallbuttons";
    //Konsultointi ja talouspalaverit
    document.getElementById("firstline").innerHTML = "Navakka valittu";
    document.getElementById("secondline").innerHTML = "Talouspalavereja vuodessa 3-4kpl";
    document.getElementById("thirdline").innerHTML = "Konsultointi toiminnan tukena";
}

function uljas() {

    //myyntilaskut
    document.getElementById("myyntilaskut").value = 200;
    document.getElementById("myyntilaskutteksti").innerHTML = "200 myyntilaskua / kk";
    //ostolaskut
    document.getElementById("ostolaskut").value = 200;
    document.getElementById("ostolaskutteksti").innerHTML = "200 ostolaskua / kk";
    //käteismaksut
    document.getElementById("käteismaksut").value = 50;
    document.getElementById("kätmaks").innerHTML = "50 käteiskuittia / kk";
    //korttimaksut
    document.getElementById("korttimaksut").value = 50;
    document.getElementById("pmaks").innerHTML = "50 korttimaksua / kk";
    //palkka
    document.getElementById("palkkabox").className = "smallboxesactivated";
    document.getElementById("palkkabox").innerHTML = "Palkanlaskenta valittu";
    document.getElementById("tuntipalkka").value = 10;
    document.getElementById("palkkah").innerHTML = "10 tuntipalkkaa";
    document.getElementById("kkpalkka").value = 10;
    document.getElementById("palkkakk").innerHTML = "10 kuukausipalkkaa";
    //projekti ja kustanns
    document.getElementById("seuranta3").className = "smallbuttonsactivated";
    document.getElementById("seuranta1").className = "smallbuttons";
    document.getElementById("seuranta2").className = "smallbuttons";
    //Konsultointi ja talouspalaverit
    document.getElementById("firstline").innerHTML = "Uljas valittu";
    document.getElementById("secondline").innerHTML = "Talouspalavereja vuodessa 5-12kpl";
    document.getElementById("thirdline").innerHTML = "Konsultointi analyyttista";
}

function summa() {

//////////////////////////////////// Laskee yhteissumman alalaidassa ////////////////////////////////////////////////////	
    var myynti = parseInt(document.getElementById("myyntilaskut").value) * 1.5;
    document.getElementById("myyntiform").value = myynti / 1.5;
    if (document.getElementById("kpmyynti").className == "smallbuttonsactivated") {
        myynti = myynti * 1.5;
    }				// KIRJANPITÄJÄ HOITAA LASKUTUKSEN KERROIN




    var ostot = parseInt(document.getElementById("ostolaskut").value) * 1.5;
    document.getElementById("ostotform").value = ostot / 1.5;
    if (document.getElementById("kpostot").className == "smallbuttonsactivated") {
        ostot = ostot * 1.5;
    }				// KIRJANPITÄJÄ HOITAA MAKSATUKSEN KERROIN	



    var kät = parseInt(document.getElementById("käteismaksut").value) * 1.5;
    var kort = parseInt(document.getElementById("korttimaksut").value) * 1.5;
    document.getElementById("käteisform").value = kät / 1.5;
    document.getElementById("kortitform").value = kort / 1.5;
    if (document.getElementById("kuitit").className == "smallbuttonsactivated") {
        kät = kät * 1.5;
        kort = kort * 1.5;
    } 		// KÄT JA KORTTI KUITIT EI JÄRJESTETTY KERROIN					



    var tuntipalkka = parseInt(document.getElementById("tuntipalkka").value) * 10;
    document.getElementById("tuntipalkkaform").value = tuntipalkka / 10;
    if (document.getElementById("tuntipalkka").value > 9) { 			// 10 TAI ENEMMÄN TUNTIPALKKAA
        if (document.getElementById("tuntipalkka").value > 19) { 		// 20 TAI ENEMMÄN
            if (document.getElementById("tuntipalkka").value > 29) { 	// 30 TAI ENEMMÄN
                tuntipalkka = tuntipalkka + 200;
            }
            else {
                tuntipalkka = tuntipalkka + 100;
            }
        } else {
            tuntipalkka = tuntipalkka + 50;
        }
    }

    var kkpalkka = parseInt(document.getElementById("kkpalkka").value) * 10;
    document.getElementById("kkpalkkaform").value = kkpalkka / 10;
    if (document.getElementById("kkpalkka").value > 9) {				// 10 TAI ENEMMÄN KK-PALKKAA
        if (document.getElementById("kkpalkka").value > 19) {			// 20 TAI ENEMMÄN
            if (document.getElementById("kkpalkka").value > 29) {		// 30 TAI ENEMMÄN
                kkpalkka = kkpalkka + 200;
            }
            else {
                kkpalkka = kkpalkka + 100;
            }
        } else {
            kkpalkka = kkpalkka + 50;
        }
    }

    var sum = parseInt(myynti) + parseInt(ostot) + parseInt(kät) + parseInt(kort) + parseInt(tuntipalkka) + parseInt(kkpalkka);

    if (document.getElementById("seuranta1").className == "smallbuttonsactivated") {
        var sum = sum * parseInt(document.getElementById("seuranta1").value);
        document.getElementById("projektiform").value = "ei seurantaa"
    }
    else if (document.getElementById("seuranta2").className == "smallbuttonsactivated") {
        var sum = sum * parseFloat(document.getElementById("seuranta2").value);
        document.getElementById("projektiform").value = "suppea seuranta"
    }
    else if (document.getElementById("seuranta3").className == "smallbuttonsactivated") {
        var sum = sum * parseFloat(document.getElementById("seuranta3").value);
        document.getElementById("projektiform").value = "laaja seuranta"
    }


    if (document.getElementById("firstline").innerHTML == "Kittana valittu") {
        var sum = sum + 50;
        document.getElementById("konsultointiform").value = "Kittana valittu";
    }
    else if (document.getElementById("firstline").innerHTML == "Navakka valittu") {
        var sum = sum + 100;
        document.getElementById("konsultointiform").value = "Navakka valittu";
    }
    else if (document.getElementById("firstline").innerHTML == "Uljas valittu") {
        var sum = sum + 250;
        document.getElementById("konsultointiform").value = "Uljas valittu";
    }


    document.getElementById('summaform').value = parseInt(sum);
    document.getElementById('summa').innerHTML = parseInt(sum) + " € / kk";
}

function apuaeinäy() {
    alert("Selain Internet Explorer:\n\nKaikki tämän sivun ominaisuudet eivät toimi Internet Explorer 8 tai alemmissa versioissa.\n\n"
            + "Varmista, että olet sallinut tämän sivuston näyttää upotetut ominaisuudet ja että sinulla on JavaScript päällä selaimessasi\n\n\n"
            + "Selain Mozilla Firefox:\n\nMikäli kaikki sivun ominaisuudet eivät näy oikein, varmista että käytössäsi on uusin Mozilla Firefox versio\n\n"
            + "Jotkin sivun ominaisuudet eivät toimi versioissa alle 23");
}

function buttonActivateSeuranta(elementID) {
    if (elementID == "seuranta1") {
        if (document.getElementById(elementID).className == "smallbuttons") {
            document.getElementById(elementID).className = "smallbuttonsactivated";
        }
        else {
            document.getElementById(elementID).className = "smallbuttons";
        }
        document.getElementById("seuranta2").className = "smallbuttons";
        document.getElementById("seuranta3").className = "smallbuttons";
    }
    else if (elementID == "seuranta2") {
        if (document.getElementById(elementID).className == "smallbuttons") {
            document.getElementById(elementID).className = "smallbuttonsactivated";
        }
        else {
            document.getElementById(elementID).className = "smallbuttons";
        }
        document.getElementById("seuranta1").className = "smallbuttons";
        document.getElementById("seuranta3").className = "smallbuttons";
    }
    else if (elementID == "seuranta3") {
        if (document.getElementById(elementID).className == "smallbuttons") {
            document.getElementById(elementID).className = "smallbuttonsactivated";
        }
        else {
            document.getElementById(elementID).className = "smallbuttons";
        }
        document.getElementById("seuranta1").className = "smallbuttons";
        document.getElementById("seuranta2").className = "smallbuttons";
    }
}