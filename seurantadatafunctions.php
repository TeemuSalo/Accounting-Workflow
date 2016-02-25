
<?php
/*
 *      PIIRRÄ KUUKAUSISEURANTA OSA 1
 */

// Jos POST lähetetty, käytetään valittua kautta
if ( isset($_POST['vaihdakk']) )
{
    // Valitse kuukausi valitusta laatikosta.
    $kuukausi = $_POST['kuukausilista'];
    $_SESSION['selected_month'] = $kuukausi;
    
	// Valitse vuosi valitusta laatikosta	
	$vuosi = $_POST['vuosilista'];
	$_SESSION['selected_year'] = $vuosi;  
}

// Jos SESSIO on olemassa, mutta ei POSTIA, käytetään SESSIOTA
else if( isset($_SESSION['selected_month']) )
{
	$kuukausi = $_SESSION['selected_month'];
	$vuosi = $_SESSION['selected_year'];
}

// Ei POSTIA eikä SESSIOTA
else 
{
    $this_month = intval(date('n'));
    $this_year = intval(date('Y'));
    
    // Tarkista onko kuluvan vuoden taulukkoa olemassa
    if( end($kaikki_vuodet) < $this_year )
    {
        // Käytetään olemassa olevaa viimeisintä vuotta, jotta ei haeta olematonta taulukkoa
        $vuosi = end($kaikki_vuodet);
        // Oletuksena joulukuu, koska eletään kuluvan vuoden tammikuuta todennäköisesti
        $kuukausi = 12;
    }
    else
    {
        // Vuositaulukko on olemassa kuluvalta vuodelta, käytetään sitä
        $vuosi = $this_year;
    
        if( $this_month > 1 )
        {

            // Seurattava kirjanpidon kuukausi on oletuksena kuluvaa kuukautta edeltävä
            $kuukausi = $this_month - 1;
            //$vuosi = end($kaikki_vuodet);

        }   
        else
        {

            // Jos kuluva kuukausi on tammikuu, seurattava kuukausi on joulukuu
            $kuukausi = 12;
            $vuosi = $vuosi - 1;

        }
    }
}

// Tarkista meneekö maksukuukausi seuraavalle kalenterivuodelle
if( $kuukausi >= 11 )
{
    
    $pay_month = $kuukausi - 10;
    $pay_year = $vuosi + 1;

}

// Maksukuukausi pysyy samalla kalenterivuodella
else
{

    $pay_month = $kuukausi + 2;
    $pay_year = $vuosi;
    
}

// Päivitetään käytettävä taulukko, mikäli vuosi muuttui tai ei
$seuranta = $seuranta_prefix . $vuosi;

// Globaalit arvot, asetetaan html pudotusvalikko-formien aktiivinen arvo tämän mukaan
$GLOBALS['g_kuukausi'] = $kuukausi;
$GLOBALS['g_vuosi'] = $vuosi;

// Muodosta maksukuukausi
$payday = '12.'.$pay_month.'.'.$pay_year;

// Päättele custom 'AS' taulukon nimi
switch ($kuukausi) {
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
    $Kommentit = $seuranta.".`Kommentit`, ";
} else {
    $Kommentit = '';
}

if (isset($_SESSION['Laskutettu'])) 
{
    $Laskutettu = $seuranta.".`Laskutettu`, ";
} else {
    $Laskutettu = '';
}

if (isset($_SESSION['TehdytTunnit']))
{
    $TehdytTunnit = $seuranta.".`Tehdyt Tunnit`, ";
} else {
    $TehdytTunnit = '';
}

if (isset($_SESSION['TYEL']))
{
    $TYEL = $seuranta.".`TYEL` AS 'TYEL $TAS_month', ";
} else {
    $TYEL = '';
}

if (isset($_SESSION['Rakentamis']))
{
    $Rakentamis = $seuranta.".`Rakentamis` AS 'Rak. $ALV_month', ";
} else {
    $Rakentamis = '';
}


$draw_seuranta_return = mysql_query("SELECT "
                      . "$seuranta.`Rivi`, "
                      . "$seuranta.`Kipitunnus`, "
                      . "$seuranta.`Asiakas`, "
                      . "$seuranta.`Aineisto Saapunut`, "
                      . "$seuranta.`Kirjanpito Tehty` , "
                      . "$seuranta.`EU` AS 'EU $ALV_month', "
                      . "$seuranta.`ALV` AS 'ALV $ALV_month', "
                      . "$seuranta.`TAS` AS 'TAS $TAS_month', "
                      . "$seuranta.`Sähköposti`, "
                      . "$Kommentit "
                      . "$Laskutettu "
                      . "$TehdytTunnit "
                      . "$TYEL "
                      . "$Rakentamis "
                      . "$rekisteri.`Tilinpäätös` "
                      . "FROM $seuranta "
					  . "LEFT JOIN $rekisteri "
                      . "ON $seuranta.`Asiakas`=$rekisteri.`Asiakas` "
                      . "WHERE $seuranta.Kuukausi = $kuukausi "
                      . "ORDER BY Asiakas");
                            
if (!$draw_seuranta_return)
{
    echo $takaisin_seurantaan;
	session_destroy(); // Tuhoa sessio tai jäät looppiin
    die('Koodi 21. Virhe yhteydessä tietokantaan: ' . mysql_error());
}
// Fields_num käytetään 'Piirrä kuukausiseuranta osa 2:ssa'
$seur_fields_num = mysql_num_fields($draw_seuranta_return); 
// Piirrä kuukausiseuranta loppuu
?>
