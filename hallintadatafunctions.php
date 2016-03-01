<?php
    /*
     *          LUO KOKONAINEN SEURANTAKUUKAUSI
     *          SAMALLE VUODELLE
     */
    if (isset($_POST['luokuukausi'])) {

        $kuluva_vuosi = $_POST['vuosi'];
        $seuraavakuukausi = $_POST['seuraavakuukausi'];
        
        $seuranta = $seuranta_prefix . $kuluva_vuosi;
        
        $ret_check_year = mysql_query("SELECT 1 FROM $seuranta LIMIT 1");
        
        if(!$ret_check_year)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 101: ' . mysql_error());
        }

        
        // Lisätään vain Kipitunnus ja nimi, Rivi tulee automaattisesti
        $sql_create_month = "INSERT INTO $seuranta (Kipitunnus, Asiakas) "
                          . "SELECT Kipitunnus, Asiakas FROM $rekisteri "
                          . "WHERE Seuranta IS NULL";

        $ret_create_month = mysql_query($sql_create_month);

        if (!$ret_create_month)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 102: ' . mysql_error());
        }
        
        $affected_rows = mysql_affected_rows();
        
        // Täytetään tyhjät kuukaudet seuraavan kuukauden numerolla
        // Voisi yhdistää aikaisempaan queryyn?
        $sql_update_month = "UPDATE $seuranta "
                          . "SET Kuukausi = '$seuraavakuukausi' "
                          . "WHERE Kuukausi IS NULL";


        $ret_update_month = mysql_query($sql_update_month);

        if (!$ret_update_month) {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 103: ' . mysql_error());
        }

        $affected_rows_2 = mysql_affected_rows();

        // Eroavaisuus vaikutetuissa riveissä?
        if ($affected_rows != $affected_rows_2) {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 104: Ota yhteyttä ylläpitäjään. ' . mysql_error());
        }
    }


    /*
     *          LUO KOKONAINEN SEURANTAKUUKAUSI
     *          SEURAAVALLE VUODELLE
     */

    if (isset($_POST['luovuosi']))
    {
        $seuraavavuosi = $_POST['vuosi'];
        $seuraavakuukausi = $_POST['seuraavakuukausi'];
        
        $seuranta = $seuranta_prefix . $seuraavavuosi;
        
        $ret_check_year = mysql_query("SELECT 1 FROM $seuranta LIMIT 1");
        
        if(!$ret_check_year)
        {
            $kuluva_vuosi = end($kaikki_vuodet);
            
            // Luodaan tyhjä taulukko
            $create_new_year = mysql_query("CREATE TABLE $seuranta "
                                          ."LIKE $seuranta_prefix" . "$kuluva_vuosi");
            if (!$create_new_year)
            {
                echo $takaisin_hallintaan;
                die('Hallintadatafunktion virhe 105: ' . mysql_error());
                
            }
        }
        else
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 106: Avattava vuosi on jo olemassa, älä päivittele ');
        }

        $sql_create_month = "INSERT INTO $seuranta (Kipitunnus, Asiakas) "
                          . "SELECT Kipitunnus, Asiakas FROM $rekisteri "
                          . "WHERE Seuranta IS NULL";

        $ret_create_month = mysql_query($sql_create_month);

        if (!$ret_create_month)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 107: ' . mysql_error());
        }
        
        $affected_rows = mysql_affected_rows();

        $sql_update_month = "UPDATE $seuranta "
                          . "SET Kuukausi = '$seuraavakuukausi' "
                          . "WHERE Kuukausi IS NULL";


        $ret_update_month = mysql_query($sql_update_month);

        if (!$ret_update_month) {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 108: ' . mysql_error());
        }

        $affected_rows_2 = mysql_affected_rows();

        if ($affected_rows != $affected_rows_2) {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 109: Kuukausiseurantaa ei voitu luoda. Ota yhteyttä ylläpitäjään. ' . mysql_error());
        }
        
        // Päivitetään vuosilista, koska init.php tulee ennen näitä sql-tapahtumia
        $kaikki_vuodet[] = $seuraavavuosi;
    }
?>


<?php
    /*
     *          LUO YKSITTÄINEN ASIAKAS KUUKAUSISEURANTAAN
     */

    if ( isset($_POST['luoasiakaskuukausi']) ) 
    {

        $seuranta_asiakas = $_POST['asiakaslista'];
        $seurantakk = $_POST['kuukausilista'];
        $seurantavuosi = $_POST['vuosilista'];

        $seuranta = $seuranta_prefix . $seurantavuosi;
        
        
        // Tarkistetaan, ettei luoda yksittäistä asiakasta uudelle kuukaudelle
        // Muuten sotkee ryhmä-lisäyksen rytmityksen
        $sql_test_current_month = "SELECT 1 FROM $seuranta WHERE Kuukausi = $seurantakk LIMIT 1";
        
        $sql_test_result = mysql_query($sql_test_current_month);
        
        if (!$sql_test_result)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 110: ' . mysql_error());
        }
        
        // Palauttaa 0 jos kuukautta ei ole olemassa
        if (mysql_num_rows($sql_test_result) == 0)
        {
            echo $takaisin_hallintaan;
            die('VIRHE: Et ole vielä luonut kuukausiseurantaa valitulle kaudelle');
        }
        
        mysql_free_result($sql_test_result);
        
        /*
         *  Hae syötettävät tiedot asiakasrekisteristä, täytyy olla perustettu
         *  Tiedot ovat Kipitunnus ja Asiakas
         */
        
        $sql = "SELECT Kipitunnus, Asiakas "
             . "FROM $rekisteri "
             . "WHERE Asiakas='$seuranta_asiakas'";

        $get_customer = mysql_query($sql);

        if (!$get_customer)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 111: ' . mysql_error());
        }
        if (mysql_num_rows($get_customer) == 0)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 112: Asiakasta ei löytynyt rekisteristä!');
        }
        if (mysql_num_rows($get_customer) > 1)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 113: Asiakasrekisteri virhe, liian monta asiakasta samalla nimellä.');
        }
        
        $row = mysql_fetch_row($get_customer);
        mysql_free_result($get_customer);

        /*
         *  Tarkista onko asiakkaalla olemassa jo lisättävä kuukausi olemassa
         */
        
        $sql = "SELECT Kuukausi "
             . "FROM $seuranta "
             . "WHERE Kuukausi='$seurantakk' AND Asiakas='$seuranta_asiakas'";

        $check_month_exists = mysql_query($sql);

        if (!$check_month_exists)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 114: ' . mysql_error());
        }
        if (mysql_num_rows($check_month_exists) != 0)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 115: Asiakkaalla on jo seuranta samalla kuukaudella!');
        }

        mysql_free_result($check_month_exists);

        /*
         *  Syötä uusi rivi kuukausiseurantaan
         */
        $sql = "INSERT INTO $seuranta "
             . "(Kipitunnus, Asiakas) "
             . "VALUES ('$row[0]','$row[1]')";

        $return_insert_month = mysql_query($sql);

        if (!$return_insert_month)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 116: ' . mysql_error());
        }

        /*
         * Täytä kuukausisarake syötetyllä arvolla
         */
        $sql = "UPDATE $seuranta "
             . "SET Kuukausi='$seurantakk' "
             . "WHERE Kuukausi IS NULL AND Kipitunnus='$row[0]' AND Asiakas='$row[1]'";

        $return_month_added = mysql_query($sql);

        if (!$return_month_added)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 117: ' . mysql_error());
        }
        if (mysql_affected_rows() > 1)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 118: Enemmän kuin yksi rivi muutettu, ota yhteyttä ylläpitäjään!');
        }
    }
?>
                
<?php
    /*
     *          LUO ASIAKAS REKISTERIIN
     */ 
    if ( isset($_POST['luoasiakasrekisteriin']) )
    {

        $kipitunnus = $_POST['kipitunnus'];
        $asiakas = $_POST['asiakasnimi'];
        $tp = $_POST['tp'];

        // Muuttuja määrittää avataanko kuukausi samalle vuodelle vai avataanko uusi vuosi
        $kuukausiseurantaan = TRUE;

        // Tarkista onko asiakas jo olemassa
        $sql = "SELECT Kipitunnus, Asiakas FROM $rekisteri WHERE Kipitunnus = '$kipitunnus' OR Asiakas = '$asiakas'";

        $check_customer_exists = mysql_query($sql);

        if (!$check_customer_exists)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 119: ' . mysql_error());
        }
        if (mysql_num_rows($check_customer_exists) != 0)
        {
            echo $takaisin_hallintaan;
            die("Hallintadatafunktion virhe 120: Asiakasnimi $asiakas tai Kipitunnus $kipitunnus on jo olemassa, ei voida luoda uudestaan. 
            Jos haluat luoda asiakkaan samalla tunnuksella tai nimellä, muokkaa rekisteritaulukkoa");
        }
        mysql_free_result($check_customer_exists);


        if(isset($_POST['passiivi']) && $_POST['passiivi'] == 'Yes')
        {
             $kuukausiseurantaan = FALSE;
        }

        // Lisää passiivi-merkintä kolumni taulukkoon?
        if(!$kuukausiseurantaan)
        {
        $sql = "INSERT INTO $rekisteri (Kipitunnus, Asiakas, Tilinpäätös, Seuranta) "
             . "VALUES ('$kipitunnus','$asiakas','$tp', 'Ei kuukausi')";
        }
        else
        {
        $sql = "INSERT INTO $rekisteri (Kipitunnus, Asiakas, Tilinpäätös) "
             . "VALUES ('$kipitunnus','$asiakas','$tp')";
        }

        $return_create_customer = mysql_query($sql);

        if (!$return_create_customer)
        {
            echo $takaisin_hallintaan;
            die('Hallintadatafunktion virhe 121: Asiakasta ei voitu luoda rekisteriin: ' . mysql_error());
        }     
    }
?>

<?php
    /*
     *          PIIRRÄ KUUKAUDEN LUONTI GUI OSA PHP
     */

    // lisätään jonoon viimeisin vuosi, mikäli on juuri avattu uusi vuosi
    $kuluva_vuosi = end($kaikki_vuodet);

    $seuranta = $seuranta_prefix . $kuluva_vuosi;

    $next_year_true = FALSE;

    // Viimeisimmän vuoden suurin kuukausi numerona
    $return_next_month = mysql_query("SELECT "
                                    ."MAX(Kuukausi) "
                                    ."FROM $seuranta");

    if (!$return_next_month)
    {
        echo $takaisin_hallintaan;
        die('Hallintadatafunktion virhe 122: ' . mysql_error());
    }
    else
    {
        $fields_num = mysql_num_fields($return_next_month);
        $field = mysql_fetch_field($return_next_month);
        //$otsikko = $field->name;

        $row = mysql_fetch_row($return_next_month);
        
        $seuraavakk = $row[0] + 1;
        $seuraavavuosi = end($kaikki_vuodet);

        if ($seuraavakk > 12)
        {
            $seuraavakk = 1;
            $seuraavavuosi = end($kaikki_vuodet) + 1;
            $next_year_true = TRUE;
        }

        mysql_free_result($return_next_month); 
    }
?>