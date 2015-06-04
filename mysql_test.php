<?php
    session_start();
    require 'init.php';
    require 'datafunctions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>JP TILIT - MySQL</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/> 
        <meta name="viewport" content="width=device-width, initial-scale=1"/>    
        <link rel="stylesheet" type="text/css" href="mysql_styles.css"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>		
    </head>

    <body>
        
        <nav class="topnav">
            <!--<a href=""><img src="jplogo.jpg"/></a>-->
            <ul>
                <a href="mysql_test.php"><li>Seuranta ja Rekisteri</li></a>
                <a href="mysql_gui.php"><li>Lisäykset ja hallinta</li></a>
                <!--
                <a href="index.html"><li id="etusivu">Etusivu</li></a>
                <a href="palvelut.html"><li id="palvelut">Palvelut</li></a>
                <a href="hintalaskuri.html"><li id="hintalaskuri">Hintalaskuri</li></a>
                <a href="yhteystiedot.html"><li id="yhteystiedot">Yhteystiedot</li></a>-->
            </ul>
        </nav>

        <div id="path"><p>JP Asiakasseuranta ja tietokanta</a></p></div>

        <section>
            <article id="kirjanpito">

                <br/>
                <select form="vaihdakuukausi" name="kuukausilista">
                    <option value="0">Valitse</option>
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
                <form id="vaihdakuukausi" action="" method="post">
                    <input type="hidden" name="jshint" value="<?php if(isset($_SESSION['selected_month']))
                                                                       {echo $_SESSION['selected_month'];} else{echo '0';} ?>" />
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
                    if (isset($_SESSION['Rakentamis'])) { ?>
                        Rak.ilmoitus<input type="checkbox" name="Rakentamis" value="Rakentamis" checked="yes"/>
                    <?php } else { ?>
                        Rak.ilmoitus<input type="checkbox" name="Rakentamis" value="Rakentamis"/>
                    <?php } ?>
                    <br/>
                    <input type='submit' name='vaihdakk' value='Vaihda'/>
                </form>
                <br/>

                    <!--
                            PIIRRÄ KUUKAUSISEURANTA OSA 2   
                     -->
                    <div class="kuukausiotsikot"><h4><?php echo 'Kuukausiseuranta ',$ALV_month ?></h4><h4> Maksupäivä <?php echo $payday ?></h4></div>
                    <table class="kuukausiseuranta">
                        
                    <tr class="kkseurantasolu">
                        <?php // printing table headers
                        for ($i = 0; $i < $seur_fields_num; $i++) {
                            $seur_field = mysql_fetch_field($draw_seuranta_return);
                            // Nimeä jokainen sarake $columniksi
                            $seur_column[$i] = $seur_field->name; ?>
                            <th><?php echo $seur_field->name ?></th>
                        <?php } ?>
                    </tr>
                    
                    <?php // printing table rows
                    while ($seur_row = mysql_fetch_row($draw_seuranta_return)) 
                    { ?>
                        <tr>
                        <?php // $row is array... foreach( .. ) puts every element
                        // of $row to $cell variable
                        $seur_iterator = 0;
                        foreach ($seur_row as $seur_cell) {
                            $seur_col = $seur_column[$seur_iterator];
                            $seur_id = $seur_row[0] . $seur_col; ?>
                            <td>
                            <div id="<?php echo $seur_id,'show1' ?>"><p><?php echo $seur_cell ?></p>
                            <button onclick="return editkausi('<?php echo $seur_id, "', '", $seur_cell ?>')"><img id="pen" src="pen.png"/></button>
                            </div>
                            <div id="<?php echo $seur_id, 'hide1' ?>" style='display:none'>
                            <form id="<?php echo $seur_id, 'seuranta' ?>" action='' method='post'>
                            <input value="<?php echo $seur_row[0] ?>" name='row1' type='hidden'/>
                            <input value="<?php echo $seur_col ?>" name='column1' type='hidden'/>
                            <input name='newvalue1' type='text' /><br/>
                            <input type='submit' name='insertkk' value='Lähetä'/>
                            <button onclick="return canceleditkausi('<?php echo $seur_id, "', '", $seur_cell ?>')">Peruuta</button>
                            </form>
                            </div>
                            </td>
                            <?php $seur_iterator++;
                        } ?>
                        </tr>
                    <?php } ?>
                    </table>
                    
                    <?php mysql_free_result($draw_seuranta_return); ?>

                <br/><br/>
                <!--
                -
                -
                -
                TAULUKKO VAIHTUU
                -
                -
                -
                -->
                <br/><br/>                
                
                <!--
                            PIIRRÄ ASIAKASREKISTERI OSA 2
                 -->
                <div class="rekisteriotsikot"><h4>Asiakasrekisteri</h4></div>
                <table class="asiakasrekisteri">
                    <tr>
                        <?php // printing table headers
                        for ($i = 0; $i < $rek_fields_num; $i++) {
                            $rek_field = mysql_fetch_field($draw_rek_return); 
                            // nimeä kolumnit myöhempää käyttöä varten
                            $rek_column[$i] = $rek_field->name; ?>
                            <th><?php echo $rek_field->name ?></th>
                        <?php } ?>     
                    </tr>

                    <?php // printing table rows
                    while ($rek_row = mysql_fetch_row($draw_rek_return)) { ?>
                        <tr>
                        <?php // $row is array... foreach( .. ) puts every element
                        // of $row to $cell variable
                        $rek_iterator = 0;
                        foreach ($rek_row as $rek_cell) {
                            $rek_col = $rek_column[$rek_iterator];
                            $rek_id = $rek_row[0] . $rek_col; ?>
                                <td>
                                <div id="<?php echo $rek_id, 'show2' ?>"><?php echo $rek_cell ?> 
                                <button onclick="return editasiakas('<?php echo $rek_id, "', '", $rek_cell ?>')"><img id="pen" src="pen.png"/></button>
                                </div>
                                <div id="<?php echo $rek_id, 'hide2' ?>" style='display:none'>
                                <form id="<?php echo $rek_id, 'rek' ?>" action='' method='get'>
                                <input value="<?php echo $rek_row[0] ?>" name='row2' type='hidden'/>
                                <input value="<?php echo $rek_col ?>" name='column2' type='hidden'/>
                                <input name='newvalue2' type='text'/><br/>
                                <input type='submit' name='insertrek' value='Lähetä'/>
                                <button onclick="return canceledit('<?php echo $rek_id, "', '", $rek_cell ?>')">Peruuta</button>
                                </form>
                                </div>
                                </td>
                        <?php $rek_iterator++; } ?>
                        </tr>
                    <?php } ?>
                </table>
                <?php mysql_free_result($draw_rek_return); ?>             

            </article>
        </section>

        <!--
        <aside>
            <ul>

            </ul>
        </aside>
        -->
        
        <!---
        <footer>
            <div id="centerfooter">
                <section id="left">
                    <h4>Yhteystiedot</h4>
                    <p>JP Tilit</p>
                    <p>Takoraudantie 2 00700 Helsinki</p>
                    <p>puh. 010 2920 910</p>
                    <p>fax. 09 386 7150</p>
                    <p>email: posti@jptilit.fi</p>
                    <br/>
                    <div id="yhtotto">
                        <form action="contact.php" method="post">
                            <p>Nimi: </p><input name="name" type="text" size="21"/>
                            <br/>
                            <p>E-mail: </p><input name="email" type="text" size="21"/>
                            <br/>
                            <p>Puh: </p><input name="puh" type="text" size="21"/>
                            <br/>
                            <p>Viesti: </p><textarea name="message" rows="4" cols="20"></textarea>
                            <br/>
                            <input type="submit" style="font-size:18pt;" name="submit" value="Lähetä"/>
                        </form>
                    </div>
                </section>

                <section id="right">
                    <ul class="botnav">
                        <a href="perustaminen.html"><li>Aloittavat yritykset</li></a>
                        <a href="talhalkehitys.html"><li>Taloushallinnon kehitys</li></a>
                        <a href="Taloyhtiot.html"><li>Taloyhtiöt</li></a>
                        <a href="kotisivut.html"><li>Kotisivut</li></a>
                        <a href="kirjanpito.html"><li>Kirjanpito</li></a>
                        <a href="palkanlaskenta.html"><li>Palkanlaskenta</li></a>
                        <a href="controller.html"><li>Controller</li></a>
                        <a href="sahkoinen.html"><li>Sähköinen taloushallinto</li></a>
                    </ul>
        -->
        <!--<div id="map-canvas"></div>-->
        <!--
</section>			
</div>
</footer>
        -->
        
        <script type="text/javascript" src="jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="tablefunctions.js"></script>
        <script type="text/javascript" src="external.js"></script>
            
    </body>
</html>