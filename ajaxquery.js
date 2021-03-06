/*
 *      KUUKAUSISEURANNAN FUNKTIOT
 *      Piilottaa ja paljastaa syöttöpainikkeet ja kentät
 *      Lähettää ajax-komennolla luodun input-kentän arvot insertajax.php tiedostoon
 */

$(document).ready(function () {
    
    // Näytä syöttökenttä ja OK / CANCEL napit
    
    $('button.show').click( function(){
        
        var showbutton = $(this);
        
        var okbutton = $(this).next();
        
        var cancelbutton = okbutton.next();
        
        cancelbutton.css({'display' : 'inline', 'right' : '2em'});
        
        okbutton.css('display', 'inline');
        
        showbutton.css('display', 'none');
    
        showbutton.closest('div').find("p").toggle();
        
        showbutton.closest('div').prepend('<input class="seuranta_input" type="text" name="name">');
        
        var prevtext = showbutton.closest('div').find("p").text();
        
        showbutton.closest('div').find('input').val( $.trim(prevtext) );
        
    });
    
    $('button.cancel').click( function (){
        
        var cancelbutton = $(this);
        
        var okbutton = cancelbutton.next();
        
        var showbutton = cancelbutton.prev();
        
        cancelbutton.css('display', 'none');
        
        okbutton.css('display', 'none');
        
        showbutton.css('display', 'inline');
        
        showbutton.closest('div').find("p").toggle();
        
        showbutton.closest('div').find('input').remove();
    
    });
    
    $('button.ok').click( function (){
        
        var okbutton = $(this);
        
        var cancelbutton = okbutton.prev();
        
        var showbutton = cancelbutton.prev();
        
        var row = showbutton.closest('tr').attr('id');
        var col = showbutton.closest('div').attr('class');
        var val = showbutton.closest('div').find('input').val();
        
        
        $.post("insertajax.php", { ajaxrow: row, ajaxcol: col, newvalue1: val }, function(data){
        
            cancelbutton.css('display', 'none');
        
            okbutton.css('display', 'none');

            showbutton.css('display', 'inline');

            showbutton.closest('div').find("p").toggle();
            
            showbutton.closest('div').find("p").text(data.trim());

            showbutton.closest('div').find('input').remove();
        
        });
    });
});