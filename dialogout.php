<?php
    /*
     *      Dialog kommentti-laatikon toiminnot SQL-taulukon kanssa
     *      Data lähetetään ajax-komennolla external.js tiedostosta
     */

    // Start session, no authenticate.php included
    session_start();

    include 'init.php';

    if ( isset($_POST['lopetus']) )
    {
        unset($_SESSION['RiviID']);
        unset($_SESSION['asiakas']);
        unset($_SESSION['kuukausi']);
    }

    if( isset( $_POST['edellinen']) )
    { 
        $asiakas = $_SESSION['asiakas'];
        
        $kuukausi = $_SESSION['kuukausi'];
        
        $kuukausi = $kuukausi - 1; if($kuukausi < 1) $kuukausi = 1;
        
        $_SESSION['kuukausi'] = $kuukausi;
        
        $sql2 = "SELECT Kommentit FROM $seuranta WHERE Asiakas='$asiakas' AND Kuukausi=$kuukausi";   

        // Make Query
        $getkommentit = mysql_query($sql2);

        if (!$getkommentit)
        {
            echo "FAIL101";
            die('DialogOut Virhe 100 syötössä: ' . mysql_error());
        }
        else
        {
            $edelliset_kommentit = mysql_fetch_row($getkommentit);

            if ( sizeof($edelliset_kommentit) < 1 )
            {
                echo "FAIL102: uuden arvon nouto epäonnistui";
            }
            else    
            {
				// TÄMÄ JSON PALAUTETAAN TAKAISIN
                echo json_encode( array( 'edel' => $edelliset_kommentit[0], 'month' => $kuukausi, 'asiakas' => $asiakas ) );
            }
        }
    }

    if (isset ( $_POST['seuraava']) )
    {
        $asiakas = $_SESSION['asiakas'];
        
        $kuukausi = $_SESSION['kuukausi'];
        
        $kuukausi = $kuukausi + 1; if($kuukausi > 12) $kuukausi = 12;
        
        $_SESSION['kuukausi'] = $kuukausi;
        
        $sql2 = "SELECT Kommentit FROM $seuranta WHERE Asiakas='$asiakas' AND Kuukausi=$kuukausi";   

        // Make Query
        $getkommentit = mysql_query($sql2);

        if (!$getkommentit)
        {
            echo "FAIL201";
            die('DialogOut Virhe 200 syötössä: ' . mysql_error());
        }
        else
        {
            $seuraavat_kommentit = mysql_fetch_row($getkommentit);

            if ( sizeof($seuraavat_kommentit) < 1 )
            {
                echo "FAIL202: uuden arvon nouto epäonnistui";
            }
            else    
            {
				// TÄMÄ JSON PALAUTETAAN TAKAISIN
                echo json_encode( array( 'seur' => $seuraavat_kommentit[0], 'month' => $kuukausi, 'asiakas' => $asiakas ) );
            }
        }
    }
    
    elseif ( isset($_POST["RiviID"]) )
    {   
        $RiviID = $_POST["RiviID"];
        $asiakas = $_POST['asiakas'];
        $kuukausi = $_POST['kuukausi'];
        
        $_SESSION['RiviID'] = $RiviID;
        $_SESSION['asiakas'] = $asiakas;
        $_SESSION['kuukausi'] = $kuukausi;

        $sql = "SELECT Kommentit FROM $seuranta WHERE Rivi=$RiviID";   

        // Make Query
        $gettext = mysql_query($sql);

        if (!$gettext)
        {
            echo "FAIL301";
            die('DialogOut Virhe 300 syötössä: ' . mysql_error());
        }
        else
        {
            $return = mysql_fetch_row($gettext);

            if ( sizeof($return) < 1 )
            {
                echo "FAIL302: uuden arvon nouto epäonnistui";
            }
            else    
            {
				// TÄMÄ JSON PALAUTETAAN TAKAISIN
                echo json_encode( array( 'kommentit' => $return[0], 'month' => $kuukausi, 'asiakas' => $asiakas ) );
            }
        }
    }

    elseif ( isset($_POST['uusiKommentti']) )
    {
        $asiakas = $_SESSION['asiakas'];
        
        $kuukausi = $_SESSION['kuukausi'];

        $uusiKommentti = $_POST['uusiKommentti'];

        $sql = "UPDATE $seuranta SET Kommentit='$uusiKommentti' WHERE Asiakas='$asiakas' AND Kuukausi=$kuukausi";

        $setkommentti = mysql_query($sql);

		// EI PALAUTETA MITÄÄN JOS QUERY ONNISTUU
        if(!$setkommentti){ echo "DialogOut Virhe 4 ". mysql_error();}   
    }

?>