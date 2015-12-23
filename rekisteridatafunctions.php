<?php
    /*
     *          SYÖTÄ ARVO ASIAKASREKISTERIIN
     */

    if (isset($_POST['insertrek']) && !empty($_POST['newvalue2']))
    {

        $rek_editrow = ($_POST['row2']);
        $rek_editcolumn = ($_POST['column2']);
        $rek_newvalue = ($_POST['newvalue2']);

        // sending query
        $sql = "UPDATE $rekisteri SET `$rek_editcolumn`='$rek_newvalue' WHERE Rivi=$rek_editrow";

        $rek_update_return = mysql_query($sql);
        
        if (!$rek_update_return)
        {
            echo $takaisin_seurantaan;
            die('Koodi 22. Virhe yhteydessä tietokantaan: ' . mysql_error());
        }
    }
?>

<?php
    /*
     *          PIIRRÄ ASIAKASREKISTERI OSA 1
     */

    $draw_rek_return = mysql_query("SELECT * FROM $rekisteri ORDER BY Asiakas");

    if (!$draw_rek_return) 
    {
        echo $takaisin_seurantaan;
        die('Koodi 23. Virhe yhteydessä tietokantaan: ' . mysql_error());
    }

    $rek_fields_num = mysql_num_fields($draw_rek_return); 
?>