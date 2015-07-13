<?php
/*
 *          
        SIIRRETTY OMAAN TIEDOSTOONSA
 
        SYÖTÄ ARVO KUUKAUSISEURANTAAN
 */
/*
if (isset($_POST['ajaxrow'])) 
{

    $editrow = ($_POST['ajaxrow']);
    $editcolumn = ($_POST['ajaxcol']);
    $newvalue = ($_POST['newvalue1']);
                    
    // curdate used for empty fields automatic insert
    $curdate = date('Y-m-d');

    // Set empty value in field as current date
    // Checks each custom column for match, strpos returns false if string isn't found
    if (empty($_POST['newvalue1']) && strpos($editcolumn, "EU") !== false) 
    {
        $sql = "UPDATE `$seuranta` SET EU='$curdate' WHERE Rivi=$editrow";
    }
    elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "ALV") !== false) 
    {
        $sql = "UPDATE $seuranta SET ALV='$curdate' WHERE Rivi=$editrow";
    }
    elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "TAS") !== false) 
    {
        $sql = "UPDATE $seuranta SET TAS='$curdate' WHERE Rivi=$editrow";
    }
    elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "TYEL") !== false)
    {
        $sql = "UPDATE $seuranta SET TYEL='$curdate' WHERE Rivi=$editrow";
    }
    elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "Sähköposti") !== false)
    {
        $sql = "UPDATE $seuranta SET `Sähköposti`='$curdate' WHERE Rivi=$editrow";
    }
    elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "Rak. Ilm.") !== false)
    {
        $sql = "UPDATE $seuranta SET `Rakentamis`='$curdate' WHERE Rivi=$editrow";
    }
                    
    // This means there was a value, value 'null' means erase field
    // Checks each custom column for match, strpos returns false if string isn't found
    elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "EU") !== false) 
    {
        if (strpos($newvalue, "null") !== false)
        {
            $sql = "UPDATE $seuranta SET EU= NULL WHERE Rivi=$editrow";  
        }
        else
        {
            $sql = "UPDATE $seuranta SET EU='$newvalue' WHERE Rivi=$editrow";
        }
    }
    elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "ALV") !== false) 
    {
        if (strpos($newvalue, "null") !== false)
        {
            $sql = "UPDATE $seuranta SET ALV= NULL WHERE Rivi=$editrow";  
        }
        else
        {
            $sql = "UPDATE $seuranta SET ALV='$newvalue' WHERE Rivi=$editrow";
        }
    }
    elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "TAS") !== false) 
    {
        if (strpos($newvalue, "null") !== false)
        {
            $sql = "UPDATE $seuranta SET TAS= NULL WHERE Rivi=$editrow";  
        }
        else
        {
            $sql = "UPDATE $seuranta SET TAS='$newvalue' WHERE Rivi=$editrow";
        }
    }
    elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "TYEL") !== false)
    {
        if (strpos($newvalue, "null") !== false)
        {
            $sql = "UPDATE $seuranta SET TYEL= NULL WHERE Rivi=$editrow";  
        }
        else
        {
            $sql = "UPDATE $seuranta SET TYEL='$newvalue' WHERE Rivi=$editrow";
        }
    }
    elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "Sähköposti") !== false)
    {
        if (strpos($newvalue, "null") !== false)
        {
            $sql = "UPDATE $seuranta SET `Sähköposti`= NULL WHERE Rivi=$editrow";  
        }
        else
        {
            $sql = "UPDATE $seuranta SET `Sähköposti`='$newvalue' WHERE Rivi=$editrow";   
        }
    }
    elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "Rak. Ilm.") !== false)
    {
        if (strpos($newvalue, "null") !== false)
        {
            $sql = "UPDATE $seuranta SET `Rakentamis`= NULL WHERE Rivi=$editrow";  
        }
        else
        {
            $sql = "UPDATE $seuranta SET `Rakentamis`='$newvalue' WHERE Rivi=$editrow";   
        }
    }
                    
    // Not a custom 'AS' column, insert value directly
    elseif (empty($_POST['newvalue1']))
    {
        $sql = "UPDATE $seuranta SET `$editcolumn`='$curdate' WHERE Rivi=$editrow";
    }
    else
    {
        if (strpos($newvalue, "null") !== false)
        {
            $sql = "UPDATE $seuranta SET `$editcolumn`= NULL WHERE Rivi=$editrow";  
        }
        else
        {
            $sql = "UPDATE $seuranta SET `$editcolumn`='$newvalue' WHERE Rivi=$editrow";   
        }
    }

    // Make Query
    $update_seuranta_return = mysql_query($sql);
                    
    if (!$update_seuranta_return)
    {
        echo $takaisin_seurantaan;
        die('Koodi 20. Virhe yhteydessä tietokantaan: ' . mysql_error());
    }
}
*/
?>

<?php
/*
 *          PIIRRÄ KUUKAUSISEURANTA OSA 1
 */

// If POST or SESSION is set, then change filter to that month
if ( isset($_POST['vaihdakk']) || isset($_SESSION['selected_month']) )
{
    // Valitse kuukausi sessiosta tai valitusta laatikosta. Tyhjä laatikkovalinta on kuluva kuukausi
    if( isset($_POST['kuukausilista']) )
    {
        $kuukausi = $_POST['kuukausilista'];
        $_SESSION['selected_month'] = $kuukausi;
    }
    else
    {
        $kuukausi = $_SESSION['selected_month'];
    }
                    
    // ALV maksupäivä oikeassa yläkulmassa
    $nextmonth = 2 + $kuukausi;
    $payday = '12.'.$nextmonth.'.'.date('Y');
}
else 
{
    // Seurattava kirjanpidon kuukausi on oletuksena kuluvaa kuukautta edeltävä
    $this_month = intval(date('n'));
    //$TAS_month = $this_month;
    $kuukausi = $this_month - 1;
                 
     // ALV maksupäivä on oletuksena kuluvaa kuukautta seuraavan kuukauden 12. päivä
    $nextmonth = $this_month;
    $payday = '12.'.$nextmonth.'.'.date('Y');
}

// Päättele custom 'AS' taulukon nimi
switch ($kuukausi) {
    case 0:
        unset($_SESSION['selected_month']);
        header('Location: http://localhost/workspace/asiakasseuranta/seuranta.php');
        break;
    case 1:
        $ALV_month = 'tammikuu';
        $TAS_month = 'helmikuu';
        break;
    case 2:
        $ALV_month = 'helmikuu';
        $TAS_month = 'maaliskuu';
        break;
    case 3:
        $ALV_month = 'maaliskuu';
        $TAS_month = 'huhtikuu';
        break;
    case 4:
        $ALV_month = 'huhtikuu';
        $TAS_month = 'toukokuu';
        break;
    case 5:
        $ALV_month = 'toukokuu';
        $TAS_month = 'kesäkuu';
        break;
    case 6:
        $ALV_month = 'kesäkuu';
        $TAS_month = 'heinäkuu';
        break;
    case 7:
        $ALV_month = 'heinäkuu';
        $TAS_month = 'elokuu';
        break;
    case 8:
        $ALV_month = 'elokuu';
        $TAS_month = 'syyskuu';
        break;
    case 9:
        $ALV_month = 'syyskuu';
        $TAS_month = 'lokakuu';
        break;
    case 10:
        $ALV_month = 'lokakuu';
        $TAS_month = 'marraskuu';
        break;
    case 11:
        $ALV_month = 'marraskuu';
        $TAS_month = 'joulukuu';
        break;
    case 12:
        $ALV_month = 'joulukuu';
        $TAS_month = 'tammikuu';
        break;
};

// Aseta tai poista SESSION arvoja checkboxien mukaan
if(isset($_POST['vaihdakk']))
{
    // Valitse checkboxien mukaan näytettävät kentät
    if (isset($_POST['Kommentit']))
    {
        $_SESSION['Kommentit'] = 'TRUE';
    } else {
        unset($_SESSION['Kommentit']);
    }

    if (isset($_POST['Laskutettu'])) 
    {
        $_SESSION['Laskutettu'] = 'TRUE';
    } else {
        unset($_SESSION['Laskutettu']);
    }

    if (isset($_POST['TehdytTunnit']))
    {
        $_SESSION['TehdytTunnit'] = 'TRUE';
    } else {
        unset($_SESSION['TehdytTunnit']);
    }
    
    if (isset($_POST['TYEL']))
    {
        $_SESSION['TYEL'] = 'TRUE';
    } else {
        unset($_SESSION['TYEL']);
    }

    if (isset($_POST['Rakentamis']))
    {
        $_SESSION['Rakentamis'] = 'TRUE';
    } else {
        unset($_SESSION['Rakentamis']);
    }
}

    // SESSION mukaan näytä tai piilota kentät
    if (isset($_SESSION['Kommentit']))
    {
        $Kommentit = '`Kommentit`, ';
    } else {
        $Kommentit = '';
    }

    if (isset($_SESSION['Laskutettu'])) 
    {
        $Laskutettu = '`Laskutettu`, ';
    } else {
        $Laskutettu = '';
    }

    if (isset($_SESSION['TehdytTunnit']))
    {
        $TehdytTunnit = '`Tehdyt Tunnit`, ';
    } else {
        $TehdytTunnit = '';
    }

    if (isset($_SESSION['TYEL']))
    {
        $TYEL = "`TYEL` AS 'TYEL $TAS_month', ";
    } else {
        $TYEL = '';
    }

    if (isset($_SESSION['Rakentamis']))
    {
        $Rakentamis = "`Rakentamis` AS 'Rak. Ilm. $ALV_month', ";
    } else {
        $Rakentamis = '';
    }

$draw_seuranta_return = mysql_query("SELECT "
                      . "`Rivi`, "
                      . "`Kipitunnus`, "
                      . "`Asiakas`, "
                      . "`Aineisto Saapunut`, "
                      . "`Kirjanpito Tehty` , "
                      . "`EU` AS 'EU $ALV_month', "
                      . "`ALV` AS 'ALV $ALV_month', "
                      . "`TAS` AS 'TAS $TAS_month', "
                      . "`Sähköposti`, "
                      . "$Kommentit "
                      . "$Laskutettu "
                      . "$TehdytTunnit "
                      . "$TYEL "
                      . "$Rakentamis "
                      . "`Tilinpäätös` "
                      . "FROM $seuranta "
                      . "WHERE Kuukausi = $kuukausi "
                      . "ORDER BY Asiakas");
                            
if (!$draw_seuranta_return)
{
    echo $takaisin_seurantaan;
    die('Koodi 21. Virhe yhteydessä tietokantaan: ' . mysql_error());
}
// Fields_num käytetään 'Piirrä kuukausiseuranta osa 2:ssa'
$seur_fields_num = mysql_num_fields($draw_seuranta_return); 
// Piirrä kuukausiseuranta loppuu
?>