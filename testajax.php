<?php
    
    include 'init.php';

    $editrow = ($_POST['row1']);
    $editcolumn = ($_POST['column1']);
    $newvalue = ($_POST['newvalue1']);

    $sql = "UPDATE $seuranta SET `$editcolumn`='$newvalue' WHERE Rivi=$editrow";

    $update_seuranta_return = mysql_query($sql);
                    
    if (!$update_seuranta_return)
    {
        echo $takaisin_seurantaan;
        die('Koodi 20. Virhe yhteydessä tietokantaan: ' . mysql_error());
    }

    $ALV_month = '5';
    $TAS_month = '6';

    $kuukausi = '5';
    

    $draw_seuranta_return = mysql_query("SELECT "
                          . "`Rivi`, "
                          . "`Kipitunnus`, "
                          . "`Asiakas`, "
                          . "`Aineisto Saapunut`, "
                          . "`EU` AS 'EU $ALV_month', "
                          . "`ALV` AS 'ALV $ALV_month', "
                          . "`TAS` AS 'TAS $TAS_month', "
                          . "`TYEL` AS 'TYEL $TAS_month', "
                          . "`Sähköposti`, "
                          //. "$Kommentit "
                          //. "$Laskutettu "
                          //. "$TehdytTunnit "
                          //. "$Rakentamis "
                          . "`Tilinpäätös` "
                          . "FROM $seuranta "
                          . "WHERE Kuukausi = $kuukausi "
                          . "ORDER BY Asiakas");

    if (!$draw_seuranta_return)
    {
        //echo $takaisin_seurantaan;
        die('Koodi 21. Virhe yhteydessä tietokantaan: ' . mysql_error());
    }
    // Fields_num käytetään 'Piirrä kuukausiseuranta osa 2:ssa'
    $seur_fields_num = mysql_num_fields($draw_seuranta_return); 
    // Piirrä kuukausiseuranta loppuu

?>