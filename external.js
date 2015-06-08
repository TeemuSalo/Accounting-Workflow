$(document).ready(function () {
    
    // Array TP sarakkeen show1 sisältö
    var arr = $('[id*=Tilinpäätösshow1] > p');
                
    $.each(arr, function (i) {

        // Hakee TP sarakkeen <p> sisällön
        var TP = $(arr[i]).text();

        // Korvaa ' - ' merkit ' / '
        // Muuten ei toimi firefoxilla
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
            $(arr[i]).css('background', 'yellow');
        }
        // Erotus 1 - 2 kuukautta
        else if( (days > 31) && (days <= 91) ) 
        {
            $(arr[i]).css('background', 'orange');
        }
        // Erotus yli 3 kuukautta
        else if( days > 91 ) 
        {
            $(arr[i]).css('background', '#CC4444');
        }
    });
    
    // kuukausipudotusvalikon indexi on aina valittu kuukausi
    var hint = $('input[name="jshint"]').val();
    $('select[name="kuukausilista"] option').eq(hint).prop('selected', true);
    
    
    // Fixed tabled headers on scrolldown
    function UpdateTableHeaders() {
   
           var el             = $(".seurantaheaders"),
               offset         = el.offset(),
               scrollTop      = $(window).scrollTop(),
               floatingHeader = $(".floatingHeader");

           if ((scrollTop >= offset.top)) {
               floatingHeader.css('visibility', 'visible');
               floatingHeader.css('font-size', '0.9em');
               
           } else {
               floatingHeader.css('visibility', 'hidden');
           }
    }
    
    var clonedHeaderRow;
    // DOM Ready      
    clonedHeaderRow = $(".seurantaheaders");
    clonedHeaderRow
        .before(clonedHeaderRow.clone())
        .css("width", clonedHeaderRow.width())
        .addClass("floatingHeader");
    
    clonedHeaderRow.children().each( function(ite) {
        
            switch(ite){
                case 0:
                    $(this).css('width', '1.2%');
                    break;
                case 1:
                    $(this).css('width', '1.2%');
                    break;
                case 2:
                    $(this).css('width', '7.2%');
                    break;
                case 3:
                    $(this).css('width', '4.0%');
                    break;
                case 4:
                    $(this).css('width', '2.6%');
                    break;
                case 5:
                    $(this).css('width', '2.6%');
                    break;
                default:
                    $(this).css('width', '2.2%');
            }
        });

    $(window)
        .scroll(UpdateTableHeaders)
        .trigger("scroll");
    
});