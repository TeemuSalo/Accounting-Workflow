$(document).ready(function () {
    
    // laskekuukausi funktio muuttaa numeron kuukauden tekstimuotoon
    // Käytetty muutamissa kohdissa
    function laskekuukausi(nro) {
        
        var month;

        switch (nro) {
        case 0:
            break;
        case 1:
            month = 'tammikuu';
            break;
        case 2:
            month = 'helmikuu';
            break;
        case 3:
            month = 'maaliskuu';
            break;
        case 4:
            month = 'huhtikuu';
            break;
        case 5:
            month = 'toukokuu';
            break;
        case 6:
            month = 'kesäkuu';
            break;
        case 7:
            month = 'heinäkuu';
            break;
        case 8:
            month = 'elokuu';
            break;
        case 9:
            month = 'syyskuu';
            break;
        case 10:
            month = 'lokakuu';
            break;
        case 11:
            month = 'marraskuu';
            break;
        case 12:
            month = 'joulukuu';
            break;
        }
        return month;
    }
    
    // Array sisältää kaikki Tilinpäätös sarakkeiden sisältö
    var arr = $('[class=Tilinpäätös] > p');
                
    $.each(arr, function (i) {

        // Hakee TP sarakkeen <p> sisällön
        var TP = $(arr[i]).text();

        // Korvaa ' - ' merkit ' / '
        // Muuten ei toimi firefoxilla päivämäärien käsittely
        var TPreplaced = TP.replace(/-/g, "/");

        // Luo päivämäärän muokatusta päivämäärästä
        // Huom GMT ajat eivät samalla tasolla nykyhetken kanssa
        var TPdate = new Date(TPreplaced);

        var curdate = new Date();

        // Ero millisekunteina?
        var datediff = new Date(curdate - TPdate);

        // Muuta ero päiviksi
        var days = datediff / 1000 / 60 / 60 / 24;

        // Erotus kuukautta ennen tai kuukautta jälkeen
        if( (days > -30) && (days <= 31) ) 
        {
                $(arr[i]).closest('td').css('background', 'yellow');
        }
        // Erotus 1 - 2 kuukautta
        else if( (days > 31) && (days <= 91) ) 
        {
                $(arr[i]).closest('td').css('background', 'orange');
        }
        // Erotus yli 3 kuukautta
        else if( days > 91 ) 
        {
                $(arr[i]).closest('td').css('background', '#CC4444');
        }
    });
    
    
    // kuukausipudotusvalikon indexi on aina valittu kuukausi
    // Tekee turhaksi 'Valitse' osion
    var hint = $('input[name="jshint"]').val();
    $('select[name="kuukausilista"] option').eq(hint).prop('selected', true);
    
    
    // Tyhjät solut värjätty, kun alv päivä lähenee
    // Värjää aina toissa kuukaudet, eli elokuussa kesäkuun
    var datenow = new Date();
    monthnow = datenow.getMonth();
    
    if( (monthnow - hint) > 0 )
    {
        var arr2 = $('table div > p:empty');

        $.each(arr2, function (i) {

            $(arr2[i]).closest('td').css('background', '#FFBBAA');

        });
    }
	
    // Kommentit dialogin luonti ja nappulat
	$('#mydiv').dialog({
		autoOpen: false,
		resizable: false,
		width: 510,
		buttons: {
            "Edellinen": function () {

                $.post("dialogout.php", { edellinen: "true" }, function (data) {
        
                    $('#mydiv textarea').val(data.edel);
                    
                    var tekstikuukausi = laskekuukausi( parseInt( data.month ) );
            
                    $('#mydiv').dialog({
                        title: "Kommentit " + data.asiakas + " " + tekstikuukausi
                    });

                },
                    dataType="json");
                
            },
            "Seuraava": function () {
                
                $.post("dialogout.php", { seuraava: "true"}, function (data) {
        
                    $('#mydiv textarea').val(data.seur);
                    
                    var tekstikuukausi = laskekuukausi( parseInt( data.month ) );
            
                    $('#mydiv').dialog({
                        title: "Kommentit " + data.asiakas + " " + tekstikuukausi
                    });
                }, 
                    dataType="json");
            },
			"Ok": function() {
                
                var uusiKommentti = $('#mydiv textarea').val();
                
                $.post("dialogout.php", { uusiKommentti: uusiKommentti }, function(data){
                    
                    $('#mydiv').dialog("close");

                });
			},
			"Cancel": function() {
                
                $.post("dialogout.php", { lopetus: "true" }, function () {
                    
                    $('#mydiv').dialog("close");

                });
			}
		}
	});

    // Dialogin ensimmäinen avaus
    // Asettaa php Session arvot samalla dialogout.php tiedostossa
	$('.Kommentit a').click(function() {
        
        var RiviID = $(this).closest("tr").attr("id");
        
        var asiakas = $(this).closest("tr").find(".Asiakas p").html();
        
        var kuukausi = $('input[name="jshint"]').val();
        
	
		$.post("dialogout.php", { RiviID: RiviID, asiakas: asiakas, kuukausi: kuukausi }, function(data){
            
            $('#mydiv textarea').val(data.kommentit);
            
            var tekstikuukausi = laskekuukausi( parseInt( data.month ) );
            
            $('#mydiv').dialog({
                title: "Kommentit " + data.asiakas + " " + tekstikuukausi
            });
        },
        dataType="json");
		
        
		$('#mydiv').dialog('open');
		return false;
	});
    

    
});
