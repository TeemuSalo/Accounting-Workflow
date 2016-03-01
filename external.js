

/*
 *      ERINÄISIÄ OMIA FUNKTIOITA
 *
 */


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
    
    /* ------------------------------------------------------------------------------ */
    
    // KUUKAUSISEURANTA VERSIO - VÄRJÄÄ TILINPÄÄTÖSSARAKE PÄIVÄMÄÄRÄN MUKAAN
    
    // Array sisältää kaikkien Tilinpäätössarakkeiden arvot
    var arr = $('[class=Tilinpäätös] > p');
                
    $.each(arr, function (i) {

        // Hakee TP sarakkeen <p> sisällön, eli tilinpäätöspäivän
        var TP = $(arr[i]).text();

        // Korvaa ' - ' merkit ' / '
        // Muuten ei toimi firefoxilla päivämäärien käsittely
        var TPreplaced = TP.replace(/-/g, "/");

        // Luo päivämäärän muokatusta päivämäärästä
        // Huom GMT ajat eivät samalla tasolla nykyhetken kanssa
        var TPdate = new Date(TPreplaced);

        var curdate = new Date();

        // Ero millisekunteina
        var datediff = new Date(curdate - TPdate);

        // Muuta ero päiviksi
        var days = datediff / 1000 / 60 / 60 / 24;

        // Erotus kuukautta ennen tai kuukautta jälkeen tilinpäätöspäivän
        if( (days > -30) && (days <= 31) ) 
        {
                $(arr[i]).closest('td').css('background', 'yellow');
        }
        // Erotus 1 - 2 kuukautta tilinpäätöspäivästä
        else if( (days > 31) && (days <= 91) ) 
        {
                $(arr[i]).closest('td').css('background', 'orange');
        }
        // Erotus yli 3 kuukautta, eli viimeinen tilinpäätöksen lähettämiskuukausi
        else if( days > 91 ) 
        {
                $(arr[i]).closest('td').css('background', '#CC4444');
        }
    });
    
    /* ------------------------------------------------------------------------------ */
    
    // Myöhemmin käytettävä muuttuja, mm dialog-kommentit
    var selected_month = $( "select[name='kuukausilista'] option:selected" ).val();
    var selected_year = $( "select[name='vuosilista'] option:selected" ).val();
    
    
    /* ------------------------------------------------------------------------------ */
    
    // AVAA TULOSTUSVERSIO NÄKYMÄSTÄ UUTEEN TABIIN
    
    $('#tulostusversio').click(function(){
    
        var w = window.open(window.location.href);
        
        $(w).load(function(){
            w.$('link[href="mysql_styles.css"]').attr('href','print_styles.css');
        });
    
    });
    
    /* ------------------------------------------------------------------------------ */
    
    // VÄRJÄÄ VALITTU RIVI KLIKATESSA
    
    $('tr').hover(function(){

        $(this).click(function(){
            
            $kaikki_solut =  $('.kuukausiseuranta').find('td');
            
            // Poista värjäys muista riveiltä ensin
            $kaikki_solut.each(function(){
                $(this).removeClass('border-row');
            });
                
            // Lisätään värjäys klikatulle riville
            $(this).find('td').addClass('border-row');
        });
        
    });
    
    
    /* ------------------------------------------------------------------------------ */
    
    // TYHJIEN SOLUVÄRJÄYS KUUKAUSISEURANNASSA
    
    // Tyhjät solut värjätty, kun alv päivä lähenee
    // Värjää aina toissa kuukaudet, eli elokuussa värjätään kesäkuun tyhjät
    var datenow = new Date();
    
    // HUOM Tammikuu on 0, helmikuu on 1
    monthnow = datenow.getMonth();
    
    yearnow = datenow.getFullYear();
    
    // Tarkasta, onko valittuna edellinen kalenterivuosi
    if( yearnow > selected_year )
    {
        // Tarkista, onko nyt tammikuu ja valittuna joulukuu
        if( monthnow - selected_month != -12 )
        {
            // Värjätään solut, tarkastelussa on yli kuukautta vanhempi jakso
            var arr2 = $('table div > p:empty');
            
            var classname = '';

            $.each(arr2, function (i) {

                classname = $(this).closest('div').prop('class');

                // Värjätään vain oleelliset solut
                if( classname.toLowerCase().indexOf("aineisto") >= 0 || +
                    classname.toLowerCase().indexOf("kirjanpito") >= 0 || +
                    classname.toLowerCase().indexOf("eu") >= 0 || +
                    classname.toLowerCase().indexOf("alv") >= 0 || +
                    classname.toLowerCase().indexOf("tas") >= 0 || +
                    classname.toLowerCase().indexOf("sähköposti") >= 0 )
                {
                    $(arr2[i]).closest('td').css('background', '#FFBBAA');
                }
            });
        }
    }
    
    // Valittuna on kuluva kalenterivuosi, 
    // tarkista onko valittuna yli kuukautta vanhempi jakso
    else if( (monthnow - selected_month) > 0 )
    {
        var arr2 = $('table div > p:empty');
        
        var classname = '';

        $.each(arr2, function (i) {
            
            classname = $(this).closest('div').prop('class');
            
            // Värjätään vain oleelliset solut
            if( classname.toLowerCase().indexOf("aineisto") >= 0 || +
                classname.toLowerCase().indexOf("kirjanpito") >= 0 || +
                classname.toLowerCase().indexOf("eu") >= 0 || +
                classname.toLowerCase().indexOf("alv") >= 0 || +
                classname.toLowerCase().indexOf("tas") >= 0 || +
                classname.toLowerCase().indexOf("sähköposti") >= 0 )
            {
                $(arr2[i]).closest('td').css('background', '#FFBBAA');
            }
        });
    }
    
    /* --------------------------------------------------------------------------------- */
	
    // KOMMENTIT DIALOGIN LUONTI JA VALINTANAPPULAT
    
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
                dataType="json")
                  .fail(function(jqXHR) {
                    alert( "error, contact webmaster: " + jqXHR.responseText );
                  });
                
            },
            "Seuraava": function () {
                
                $.post("dialogout.php", { seuraava: "true"}, function (data) {
        
                    $('#mydiv textarea').val(data.seur);
                    
                    var tekstikuukausi = laskekuukausi( parseInt( data.month ) );
            
                    $('#mydiv').dialog({
                        title: "Kommentit " + data.asiakas + " " + tekstikuukausi
                    });
                }, 
                dataType="json")
                .fail(function(jqXHR) {
                    alert( "error, contact webmaster: " + jqXHR.responseText );
                  });
            },
			"Ok": function() {
                
                var uusiKommentti = $('#mydiv textarea').val();
                
                $.post("dialogout.php", { uusiKommentti: uusiKommentti }, function(data){
                    
                    $('#mydiv').dialog("close");

                })
                .fail(function(jqXHR) {
                    alert( "error, contact webmaster: " + jqXHR.responseText );
                  });
			},
			"Cancel": function() {
                
                $.post("dialogout.php", { lopetus: "true" }, function () {
                    
                    $('#mydiv').dialog("close");

                });
			}
		}
	});
    
    
    /* ------------------------------------------------------------------------------ */
    

    // DIALOGIN AVAUS
    
    // Asettaa php SESSION arvot samalla dialogout.php tiedostossa
    // SESSION arvoja käytetään dialogin näppäinten toiminnoissa
	$('.Kommentit a').click(function() {
        
        var RiviID = $(this).closest("tr").attr("id");
        
        var asiakas = $(this).closest("tr").find(".Asiakas p").html();
        
        var kuukausi = selected_month;
		
	
		$.post("dialogout.php", { RiviID: RiviID, asiakas: asiakas, kuukausi: kuukausi }, function(data){
            
            $('#mydiv textarea').val(data.kommentit);
            
            var tekstikuukausi = laskekuukausi( parseInt( data.month ) );
            
            $('#mydiv').dialog({
                title: "Kommentit " + data.asiakas + " " + tekstikuukausi
            });
        },
        dataType="json");
		
        $('#mydiv').dialog({'dialogClass':'custom_ui'});
		$('#mydiv').dialog('open');
		return false;
	});
    

    
});