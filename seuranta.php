<?php
	require 'authenticate.php';
    require 'init.php';
    require 'seurantadatafunctions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>JP TILIT - MySQL</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/> 
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
		
		<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
		
        <link rel="stylesheet" type="text/css" href="mysql_styles.css"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>	
    </head>

    <body>

        <div id="path">
            <div><form action="" method="post"><input type="submit" name="logout" value="Logout"></form></div>
            <p>JP Asiakasseuranta ja tietokanta</a></p>
            <p>Tervetuloa <?php echo $_SESSION['authenticate']; ?></p>
            <nav class="topnav">
                <ul>
                    <a href="seuranta.php"><li>Seuranta</li></a>
                    <a href="rekisteri.php"><li>Rekisteri</li></a>
                    <a href="hallinta.php"><li>Lisäykset ja hallinta</li></a>
                </ul>
            </nav>
        </div>


            <article id="kirjanpito">
                
                <div class="vasemmalle">
                    <select form="vaihdakuukausi" name="kuukausilista">
                        <?php

                            foreach (range(1,12,1) as $kuukausi){
                                
                                // Päättele kuukauden nimi tekstiksi
                                switch ($kuukausi) {
                                    case 1:
                                        $kuukausi_nimi = 'tammikuu';
                                        break;
                                    case 2:
                                        $kuukausi_nimi = 'helmikuu';
                                        break;
                                    case 3:
                                        $kuukausi_nimi = 'maaliskuu';
                                        break;
                                    case 4:
                                        $kuukausi_nimi = 'huhtikuu';
                                        break;
                                    case 5:
                                        $kuukausi_nimi = 'toukokuu';
                                        break;
                                    case 6:
                                        $kuukausi_nimi = 'kesäkuu';
                                        break;
                                    case 7:
                                        $kuukausi_nimi = 'heinäkuu';
                                        break;
                                    case 8:
                                        $kuukausi_nimi = 'elokuu';
                                        break;
                                    case 9:
                                        $kuukausi_nimi = 'syyskuu';
                                        break;
                                    case 10:
                                        $kuukausi_nimi = 'lokakuu';
                                        break;
                                    case 11:
                                        $kuukausi_nimi = 'marraskuu';
                                        break;
                                    case 12:
                                        $kuukausi_nimi = 'joulukuu';
                                        break;
                                };
                            ?>
                            <option value="<?php echo $kuukausi ?>" <?php if ( $kuukausi == $g_kuukausi ) echo ' selected '; ?> ><?php echo $kuukausi_nimi ?></option>
                            <?php }    
                        ?>
                    </select>
					
                    <select form="vaihdakuukausi" name="vuosilista">
                    <?php
                            
                        foreach ($kaikki_vuodet as $vuosi){ ?>
                        
                            <option value="<?php echo $vuosi ?>" <?php if ( $vuosi == $g_vuosi ) echo ' selected '; ?> > <?php echo $vuosi ?></option>
                        
                        <?php }
                    ?>
                    </select>

                    <form id="vaihdakuukausi" action="" method="post">
                        <?php
                        if (isset($_SESSION['Kommentit'])) { ?>
                            Kommentit<input type="checkbox" name="Kommentit" value="Kommentit" checked="yes"/>
                        <?php } else { ?>
                            Kommentit<input type="checkbox" name="Kommentit" value="Kommentit"/>
                        <?php }

                        if (isset($_SESSION['Laskutettu'])) { ?>
                            Laskutettu<input type="checkbox" name="Laskutettu" value="Laskutettu" checked="yes"/>
                        <?php } else { ?>
                            Laskutettu<input type="checkbox" name="Laskutettu" value="Laskutettu"/>
                        <?php }

                        if (isset($_SESSION['TehdytTunnit'])) { ?>
                            Tunnit<input type="checkbox" name="TehdytTunnit" value="Tehdyt Tunnit" checked="yes"/>
                        <?php } else { ?>
                            Tunnit<input type="checkbox" name="TehdytTunnit" value="Tehdyt Tunnit"/>
                        <?php }

                        if (isset($_SESSION['TYEL'])) { ?>
                            TYEL<input type="checkbox" name="TYEL" value="TYEL" checked="yes"/>
                        <?php } else { ?>
                            TYEL<input type="checkbox" name="TYEL" value="TYEL"/>
                        <?php }

                        if (isset($_SESSION['Rakentamis'])) { ?>
                            Rak.ilmoitus<input type="checkbox" name="Rakentamis" value="Rakentamis" checked="yes"/>
                        <?php } else { ?>
                            Rak.ilmoitus<input type="checkbox" name="Rakentamis" value="Rakentamis"/>
                        <?php } ?>
                        <br/>
                        <input type='submit' name='vaihdakk' value='Vaihda'/>
                    </form>
                </div>
                
                    <!--
                            PIIRRÄ KUUKAUSISEURANTA OSA 2   
                     -->
                    <div class="kuukausiotsikot"><h4><?php echo 'Kuukausiseuranta ',$ALV_month ?></h4><h4> Maksupäivä <?php echo $payday ?></h4></div>
                    
					<div id="mydiv" style="display:none;">
                        <textarea spellcheck="false" rows="20" cols="50"></textarea>
                    </div>
					
					<div class="container">
                        <div class="tablecontainer">
                            <table class="kuukausiseuranta">

                            <tr class="seurantaheaders" >
                                <?php // printing table headers
                                for ($i = 0; $i < $seur_fields_num; $i++) {
                                    $seur_field = mysql_fetch_field($draw_seuranta_return);
                                    // Nimeä jokainen sarake $columniksi
                                    $seur_column[$i] = $seur_field->name; ?>
                                    <th><?php echo $seur_field->name ?> <div><?php echo $seur_field->name ?></div> </th> <!-- TUPLANA -->
                                <?php } ?>
                            </tr>

                            <?php // printing table rows
                            while ($seur_row = mysql_fetch_row($draw_seuranta_return)) 
                            { ?>
                                <tr id="<?php echo $seur_row[0] ?>">
                                <?php 
                                // $row is array... foreach( .. ) puts every element
                                // of $row to $cell variable
                                $seur_iterator = 0;
                                foreach ($seur_row as $seur_cell) 
                                {
                                    $seur_col = $seur_column[$seur_iterator];
                                    $seur_id = $seur_row[0] . $seur_col; ?>
                                    <td class="<?php echo $seur_col ?>">
                                        <div class="<?php echo $seur_col; ?>">

                                            <?php if(strpos($seur_col, "Kommentit") === false): ?>
                                                <p><?php echo $seur_cell; ?></p>
                                            <?php else:
                                                if($seur_cell != ""): ?>
                                                    <a href="#"><?php echo "Kommentit"; ?></a>
                                                <?php else: ?>
                                                    <a href="#"><?php echo "Tyhjä"; ?></a>
                                                <?php endif; ?>
                                            <?php endif ?>

                                            <?php if( 	strpos($seur_col, "Rivi") === false && 
                                                        strpos($seur_col, "Kipitunnus") === false && 
                                                        strpos($seur_col, "Asiakas") === false &&
                                                        strpos($seur_col, "Kommentit") === false &&
                                                        strpos($seur_col, "Tilinpäätös") === false) : ?>

                                                            <button class="show"><img class="pen" src="pen.png"/></button>
                                                            <button class="cancel"><img class="pen" src="cancel.png" alt=""/></button>
                                                            <button class="ok"><img class="pen" src="check.png" alt=""/></button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <?php $seur_iterator++; ?>
                                <?php } ?>
                                </tr>
                            <?php } ?>
                            </table>
                        </div>
                        <div class="pohjainfo">Asiakkaita yhteensä: <?php echo mysql_num_rows($draw_seuranta_return) ?></div>
                        <button id="tulostusversio"><b>Tulostusversio</b></div>
                    </div>
                    <?php mysql_free_result($draw_seuranta_return); ?>

            </article>

        
        <script type="text/javascript" src="jquery-1.11.3.min.js"></script>
		<script src="jquery-ui/external/jquery/jquery.js"></script>
		<script src="jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="external.js"></script>
        <script type="text/javascript" src="ajaxquery.js"></script>
            
    </body>
</html>
