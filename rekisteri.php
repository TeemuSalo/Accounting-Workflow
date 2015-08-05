<?php
    require 'init.php';
    require 'rekisteridatafunctions.php';
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
                
                <!-- PIIRRÄ KUUKAUSISEURANTA OSA 2 -->
                    
                <!--<br/><br/>-->
                <!--
                -
                -
                -
                TAULUKKO VAIHTUU
                -
                -
                -
                -->
                <!--<br/><br/>-->                
                
                <!-- PIIRRÄ ASIAKASREKISTERI OSA 2 -->
                
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
                                        <button onclick="return editasiakas('<?php echo $rek_id, "', '", $rek_cell ?>')">
                                            <img class="pen" src="pen.png"/>
                                        </button>
                                    </div>
                                        <div id="<?php echo $rek_id, 'hide2' ?>" style='display:none'>
                                            <form id="<?php echo $rek_id, 'rek' ?>" action='' method='post'>
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
        
        <script type="text/javascript" src="jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="tablefunctions.js"></script>
        <script type="text/javascript" src="external.js"></script>
            
    </body>
</html>