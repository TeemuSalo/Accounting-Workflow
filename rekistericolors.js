    
    // VÄRJÄÄ LÄHESTYVÄT TILINPÄÄTÖKSET

    // Array sisältää kaikkien Tilinpäätössarakkeiden arvot
    var arr = $('[class=Tilinpäätös]');
                
    $.each(arr, function (i) {

        // Hakee TP sarakkeen <div> sisällön, eli tilinpäätöspäivän
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


    // VÄRJÄÄ PALKKAILMOITUKSET JOISSA ON EDELLISEN VUODEN PÄIVÄMÄÄRÄT

    // Array sisältää kaikkien Tilinpäätössarakkeiden arvot
    var arr = $('[class=Palkkailmoitus]');
                
    $.each(arr, function (i) {
        
        // Hakee PI sarakkeen <div> sisällön, eli palkkailmoituspäivän
        var PI = $(arr[i]).text();

        // Korvaa ' - ' merkit ' / '
        // Muuten ei toimi firefoxilla päivämäärien käsittely
        var PIreplaced = PI.replace(/-/g, "/");

        // Luo päivämäärän muokatusta päivämäärästä
        var PIdate = new Date(PIreplaced);
        
        var PI_year = PIdate.getFullYear();
        
        var current_date = new Date();

        var current_year = current_date.getFullYear();
        
        // sarakkeen päivämäärän vuosi on edellinen tai aikaisempi vuosi
        // Sarakkeen arvo ei saa olla 0000-00-00, muuten värjätään
        if( current_year > PI_year && PI.search('0000') < 0 )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
        // isNaN tulkitsee sarakkeen arvon 0000-00-00 ei-luvuksi
        // isNaN tulkitsee tyhjän arvon luvuksi, eli isNaN(null) == false
        else if( isNaN(PI) == false  )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
    });

    /* ------------------------------------------------------------------------------ */


    // VÄRJÄÄ TyEL-ILMOITUKSET JOISSA ON EDELLISEN VUODEN PÄIVÄMÄÄRÄT

    // Array sisältää kaikkien TyEL-ilmoitussarakkeiden arvot
    var arr = $('[class=TyEL-ilmoitus]');
                
    $.each(arr, function (i) {
        
        // Hakee PI sarakkeen <div> sisällön, eli palkkailmoituspäivän
        var PI = $(arr[i]).text();

        // Korvaa ' - ' merkit ' / '
        // Muuten ei toimi firefoxilla päivämäärien käsittely
        var PIreplaced = PI.replace(/-/g, "/");

        // Luo päivämäärän muokatusta päivämäärästä
        var PIdate = new Date(PIreplaced);
        
        var PI_year = PIdate.getFullYear();
        
        var current_date = new Date();

        var current_year = current_date.getFullYear();
        
        // sarakkeen päivämäärän vuosi on edellinen tai aikaisempi vuosi
        // Sarakkeen arvo ei saa olla 0000-00-00, muuten värjätään
        if( current_year > PI_year && PI.search('0000') < 0 )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
        // isNaN tulkitsee sarakkeen arvon 0000-00-00 ei-luvuksi
        // isNaN tulkitsee tyhjän arvon luvuksi, eli isNaN(null) == false
        else if( isNaN(PI) == false  )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
    });

    /* ------------------------------------------------------------------------------ */


    // VÄRJÄÄ TYÖTTÖMYYSVAKUUTUSILMOITUKSET JOISSA ON EDELLISEN VUODEN PÄIVÄMÄÄRÄT

    // Array sisältää kaikkien Työttömyysvakuutussarakkeiden arvot
    var arr = $('[class=Tyött\\.Vak\\.Ilm]');
                
    $.each(arr, function (i) {
        
        // Hakee PI sarakkeen <div> sisällön, eli palkkailmoituspäivän
        var PI = $(arr[i]).text();

        // Korvaa ' - ' merkit ' / '
        // Muuten ei toimi firefoxilla päivämäärien käsittely
        var PIreplaced = PI.replace(/-/g, "/");

        // Luo päivämäärän muokatusta päivämäärästä
        var PIdate = new Date(PIreplaced);
        
        var PI_year = PIdate.getFullYear();
        
        var current_date = new Date();

        var current_year = current_date.getFullYear();
        
        // sarakkeen päivämäärän vuosi on edellinen tai aikaisempi vuosi
        // Sarakkeen arvo ei saa olla 0000-00-00, muuten värjätään
        if( current_year > PI_year && PI.search('0000') < 0 )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
        // isNaN tulkitsee sarakkeen arvon 0000-00-00 ei-luvuksi
        // isNaN tulkitsee tyhjän arvon luvuksi, eli isNaN(null) == false
        else if( isNaN(PI) == false  )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
    });

    /* ------------------------------------------------------------------------------ */


    // VÄRJÄÄ TAPATURMAILMOITUKSET JOISSA ON EDELLISEN VUODEN PÄIVÄMÄÄRÄT

    // Array sisältää kaikkien Tapaturmailmoitusssarakkeiden arvot
    var arr = $('[class=TapaturmaIlm]');
                
    $.each(arr, function (i) {
        
        // Hakee PI sarakkeen <div> sisällön, eli palkkailmoituspäivän
        var PI = $(arr[i]).text();

        // Korvaa ' - ' merkit ' / '
        // Muuten ei toimi firefoxilla päivämäärien käsittely
        var PIreplaced = PI.replace(/-/g, "/");

        // Luo päivämäärän muokatusta päivämäärästä
        var PIdate = new Date(PIreplaced);
        
        var PI_year = PIdate.getFullYear();
        
        var current_date = new Date();

        var current_year = current_date.getFullYear();
        
        // sarakkeen päivämäärän vuosi on edellinen tai aikaisempi vuosi
        // Sarakkeen arvo ei saa olla 0000-00-00, muuten värjätään
        if( current_year > PI_year && PI.search('0000') < 0 )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
        // isNaN tulkitsee sarakkeen arvon 0000-00-00 ei-luvuksi
        // isNaN tulkitsee tyhjän arvon luvuksi, eli isNaN(null) == false
        else if( isNaN(PI) == false  )
        {
            $(arr[i]).closest('td').css('background', '#dd4444');
        }
    });

    /* ------------------------------------------------------------------------------ */
    
    //Värjää valittu rivi klikattaessa
    //Poista värjäys muista riveiltä
    $('tr').hover(function(){

        $(this).click(function(){
            
            $kaikki_solut =  $('.asiakasrekisteri').find('td');
            
            $kaikki_solut.each(function(){
                $(this).removeClass('rek-border-row');
            });
                
            $(this).find('td').addClass('rek-border-row');
        });
        
    });
    
    /* ------------------------------------------------------------------------------ */