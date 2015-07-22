<!DOCTYPE html>
<html>
    <head>
        <title>JP TILIT - MySQL GUI</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/> 
        <meta name="viewport" content="width=device-width, initial-scale=1"/>    
        <link rel="stylesheet" type="text/css" href="mysql_styles.css"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>	
    </head>

    <body>
        
        <?php
            // PHP INIT.php
            $db_host = 'localhost';
            $db_user = 'root';
            $db_pwd = '';
            $database = 'jp_asiakkaat';

            $rekisteri = 'jp_asiakasrekisteri';
            $seuranta = 'jp_kuukausiseuranta';

            $takaisin_hallintaan = '<a href="hallinta.php">TAKAISIN</a><br/><br/>';

            $conn = mysql_connect($db_host, $db_user, $db_pwd);
            if (!$conn)
                die("Can't connect to database");

            if (!mysql_select_db($database))
                die("Can't select database");

            mysql_query("SET NAMES 'utf8'");
        ?>

        <div id="path">
            <p>JP Asiakasseuranta ja tietokanta</a></p>
            <nav class="topnav">
                <!--<a href=""><img src="jplogo.jpg"/></a>-->
                <ul>
                    <a href="seuranta.php"><li>Seuranta</li></a>
                    <a href="rekisteri.php"><li>Rekisteri</li></a>
                    <a href="hallinta.php"><li>Lisäykset ja hallinta</li></a>
                </ul>
            </nav>
        </div>

        <section>
            <article id="kirjanpito">

                <br/>
                
                <?php
                /*
                 *          LUO KOKONAINEN SEURANTAKUUKAUSI
                 */
                if (isset($_POST['luokuukausi'])) {
                    
                    $vuosi = $_POST['vuosi'];
                    $seuraavakuukausi = $_POST['seuraavakuukausi'];
                    
                    $sql_create_month = "INSERT INTO $seuranta (Kipitunnus, Asiakas, Tilinpäätös) "
                                      . "SELECT Kipitunnus, Asiakas, Tilinpäätös FROM $rekisteri "
                                      . "WHERE Seuranta IS NULL";
                    
                    $ret_create_month = mysql_query($sql_create_month);
                    
                    if (!$ret_create_month) {
                        echo $takaisin_hallintaan;
                        die('Koodi 38. Virhe yhteydessä tietokantaan: ' . mysql_error());
                    }
                    $affected_rows = mysql_affected_rows();
                    
                    $sql_update_month = "UPDATE $seuranta "
                                      . "SET Kuukausi = '$seuraavakuukausi' "
                                      . "WHERE Kuukausi IS NULL";
                                        
                    
                    $ret_update_month = mysql_query($sql_update_month);
                    
                    if (!$ret_update_month) {
                        echo $takaisin_hallintaan;
                        die('Koodi 39. Virhe yhteydessä tietokantaan: ' . mysql_error());
                    }
                    
                    $affected_rows_2 = mysql_affected_rows();
                    
                    if ($affected_rows != $affected_rows_2) {
                        echo $takaisin_hallintaan;
                        die('Koodi 40. Kuukausiseurantaa ei voitu luoda. Ota yhteyttä ylläpitäjään ' . mysql_error());
                    }
                }
                ?>
                
                <?php
                /*
                 *          LUO YKSITTÄINEN ASIAKASKUUKAUSI
                 */
                if (isset($_POST['luoasiakaskuukausi'])) {
                    
                    $seuranta_asiakas = $_POST['asiakaslista'];
                    $seurantakk = $_POST['kuukausilista'];
                    
                    /*
                     *  Hae syötettävät tiedot asiakasrekisteristä, täytyy olla perustettu
                     *  Tiedot ovat Kipitunnus, Asiakas, Tilinpäätös
                     */
                    $sql = "SELECT Kipitunnus, Asiakas, Tilinpäätös "
                         . "FROM $rekisteri "
                         . "WHERE Asiakas='$seuranta_asiakas'";
                    
                    $get_customer = mysql_query($sql);
                    
                    if (!$get_customer) {
                        echo $takaisin_hallintaan;
                        die('Koodi 41. Virhe yhteydessä tietokantaan: ' . mysql_error());
                    }
                    if (mysql_num_rows($get_customer) == 0) {
                        echo $takaisin_hallintaan;
                        die('Koodi 42. Asiakasta ei löytynyt rekisteristä!');
                    }
                    if (mysql_num_rows($get_customer) > 1) {
                        echo $takaisin_hallintaan;
                        die('Koodi 43. Asiakasrekisteri virhe: Liian monta asiakasta samalla nimellä. Ota yhteyttä ylläpitäjään');
                    }
                    $row = mysql_fetch_row($get_customer);
                    mysql_free_result($get_customer);
                    
                    /*
                     *  Tarkista onko asiakkaalla olemassa jo syötetty kuukausi olemassa
                     */
                    $sql = "SELECT Kuukausi "
                         . "FROM $seuranta "
                         . "WHERE Kuukausi='$seurantakk' AND Asiakas='$seuranta_asiakas'";
                    
                    $check_month_exists = mysql_query($sql);
                    
                    if (!$check_month_exists) {
                        echo $takaisin_hallintaan;
                        die('Koodi 44. Virhe yhteydessä tietokantaan: ' . mysql_error());
                    }
                    if (mysql_num_rows($check_month_exists) != 0) {
                        echo $takaisin_hallintaan;
                        die('Koodi 45. Asiakkaalla on jo seuranta samalla kuukaudella!');
                    }
                    
                    mysql_free_result($check_month_exists);
                    
                    /*
                     *  Syötä uusi rivi kuukausiseurantaan
                     */
                    $sql = "INSERT INTO $seuranta "
                         . "(Kipitunnus, Asiakas, Tilinpäätös) "
                         . "VALUES ('$row[0]','$row[1]','$row[2]')";
                    
                    $return_insert_month = mysql_query($sql);
                    
                    if (!$return_insert_month) {
                        echo $takaisin_hallintaan;
                        die('Koodi 46. Virhe yhteydessä tietokantaan: ' . mysql_error());
                    }
                    
                    /*
                     * Täytä kuukausisarake syötetyllä arvolla
                     */
                    $sql = "UPDATE $seuranta "
                         . "SET Kuukausi='$seurantakk' "
                         . "WHERE Kuukausi IS NULL AND Kipitunnus='$row[0]' AND Asiakas='$row[1]'";
                    
                    $return_month_added = mysql_query($sql);
                    
                    if (!$return_month_added) {
                        echo $takaisin_hallintaan;
                        die('Koodi 47. Virhe yhteydessä tietokantaan: ' . mysql_error());
                    }
                    if (mysql_affected_rows() > 1){
                        echo $takaisin_hallintaan;
                        die('Koodi 48. Enemmän kuin yksi rivi muutettu, ota yhteyttä ylläpitäjään');
                    }
                }
                ?>
                
                <?php
                /*
                 *          LUO ASIAKAS REKISTERIIN
                 */ 
                if (isset($_POST['luoasiakasrekisteriin'])) {
                    
                    $kipitunnus = $_POST['kipitunnus'];
                    $asiakas = $_POST['asiakasnimi'];
                    $tp = $_POST['tp'];
                    
                    $kuukausiseurantaan = TRUE;
                    
                    // Tarkista onko asiakas jo olemassa
                    $sql = "SELECT Kipitunnus, Asiakas FROM $rekisteri WHERE Kipitunnus = '$kipitunnus' OR Asiakas = '$asiakas'";
                    
                    $check_customer_exists = mysql_query($sql);
                    
                    if (!$check_customer_exists) {
                        echo $takaisin_hallintaan;
                        die('Koodi 49. Virhe yhteydessä tietokantaan: ' . mysql_error());
                    }
                    if (mysql_num_rows($check_customer_exists) != 0){
                        echo $takaisin_hallintaan;
                        die("Koodi 50. Asiakasnimi $asiakas tai Kipitunnus $kipitunnus on jo olemassa, ei voida luoda uudestaan. 
                        Jos haluat luoda asiakkaan samalla tunnuksella tai nimellä, muokkaa rekisteritaulukkoa");
                    }
                    mysql_free_result($check_customer_exists);
                    
                    
                    // Lisää passiivi kolumni taulukkoon
                    if(isset($_POST['passiivi']) && $_POST['passiivi'] == 'Yes') {
                         $kuukausiseurantaan = FALSE;
                     }
           
                    if(!$kuukausiseurantaan){
                    $sql = "INSERT INTO $rekisteri (Kipitunnus, Asiakas, Tilinpäätös, Seuranta) "
                         . "VALUES ('$kipitunnus','$asiakas','$tp', 'Ei kuukausi')";
                    }
                    else{
                    $sql = "INSERT INTO $rekisteri (Kipitunnus, Asiakas, Tilinpäätös) "
                         . "VALUES ('$kipitunnus','$asiakas','$tp')";
                    }
                    
                    $return_create_customer = mysql_query($sql);
                    
                    if (!$return_create_customer) {
                        echo $takaisin_hallintaan;
                        die('Koodi 51. Asiakasta ei voitu luoda rekisteriin: ' . mysql_error());
                    }     
                }
                ?>

                <?php
                /*
                 *          PIIRRÄ KUUKAUDEN LUONTI GUI
                 */
                $disable_button = FALSE;
                $return_next_month = mysql_query("SELECT "
                        . "MAX(Kuukausi) AS 'Seuraava kuukausi' "
                        . "FROM $seuranta");
                            
                if (!$return_next_month) {
                    echo $takaisin_hallintaan;
                    die('Koodi 52. Virhe yhteydessä tietokantaan: ' . mysql_error());
                }
                else{
                    $fields_num = mysql_num_fields($return_next_month);
                    $field = mysql_fetch_field($return_next_month);
                    $otsikko = $field->name;

                    $row = mysql_fetch_row($return_next_month);
                    $seuraavakk = $row[0] + 1;
                    
                    if ($seuraavakk > 12){
                        $seuraavakk = 'vuosi täynnä';
                        $disable_button = TRUE;
                    }

                    mysql_free_result($return_next_month); ?>

                        <h4>Tällä luodaan uusi seurantakuukausi kaikille seurattaville yrityksille</h4>
                        <table id="luokuukausi">
                            <tr><td>Vuosi</td><td><?php echo $otsikko ?></td></tr>

                            <tr>
                                <td>2015</td><td><?php echo $seuraavakk ?></td>
                                <?php if (!$disable_button) { ?>
                                <td><form class="GUI_form" action="" method="post">
                                    <input type='hidden' name='vuosi' value='2015'/>
                                    <input type='hidden' name='seuraavakuukausi' value='<?php echo $seuraavakk ?>'/>
                                    <input type='submit' name='luokuukausi' value='LUO KUUKAUSI'/>
                                </form></td>
                                <?php } else if($disable_button) { ?>
                                <td><form><input type='submit' name='' value='EI VOI LUODA'/></form></td>
                                <?php } ?>
                            </tr>
                        </table>
                <?php } ?>
                
            </article>

            <!--
                VALIKOT YKSITTÄISEN KUUKAUDEN LUOMISEEN
            -->
            <article>
                <h4>Tällä lisäät kuukausiseurantaa yksittäisen asiakkaan tietyn kuukauden</h4>
                <h4>Asiakas täytyy olla perustettuna rekisteriin, jotta se näkyy listalla</h4>
                <select form="valitseasiakas" name="kuukausilista">        
                    <option value="1">Tammikuu</option>
                    <option value="2">Helmikuu</option>
                    <option value="3">Maaliskuu</option>
                    <option value="4">Huhtikuu</option>
                    <option value="5">Toukokuu</option>
                    <option value="6">Kesäkuu</option>
                    <option value="7">Heinäkuu</option>
                    <option value="8">Elokuu</option>
                    <option value="9">Syyskuu</option>
                    <option value="10">Lokakuu</option>
                    <option value="11">Marraskuu</option>
                    <option value="12">Joulukuu</option>
                </select>
                <br/>
                <select form="valitseasiakas" name="asiakaslista">        
                    <?php 
                        $return_customer_list = mysql_query("SELECT Asiakas FROM $rekisteri ORDER BY Asiakas");
                        while ($customers = mysql_fetch_row($return_customer_list)){
                        foreach ($customers as $customer){ ?>
                            <option value="<?php echo $customer ?>"><?php echo $customer ?></option>
                        <?php } 
                        }?>
                </select>
                <form id="valitseasiakas" class="GUI_form" action="" method="post">
                    <input type="submit" name="luoasiakaskuukausi" value="Luo seurantaan"></input>
                </form>
                
            </article>  
                

            <!--
                VALIKOT ASIAKKAAN LUOMISEKSI REKISTERIIN
            -->
            <article>
                <h4>Luo uusi asiakas rekisteriin. Et voi luoda asiakkaita samalla nimellä tai yritystunnuksella</h4>
                <form class="GUI_form" action="" method="post">
                    <p>Kipitunnus</p>
                    <input type="text" name="kipitunnus" value=""></input>
                    <p>Asiakas nimi</p>
                    <input type="text" name="asiakasnimi" value=""></input>
                    <p>Tilinpäätöspäivä</p>
                    <input type="text" name="tp" value=""></input><br/>
                    Ei kuukausiseurantaan <input type="checkbox" name="passiivi" value="Yes"></input><br/>
                    <input type="submit" name="luoasiakasrekisteriin" value="Luo Rekisteriin"></input>
                </form>
                
            </article>
        </section>

        
        <script type="text/javascript" src="jquery-1.11.3.min.js"></script>
        <script type="text/javascript">

        </script>
    </body>
</html>