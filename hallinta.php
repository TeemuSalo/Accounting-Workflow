<?php
	require 'init.php';
    require 'hallintadatafunctions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Accounting Workflow Demo</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/> 
        <meta name="viewport" content="width=device-width, initial-scale=1"/>    
        <link rel="stylesheet" type="text/css" href="mysql_styles.css"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>	
    </head>

    <body>
        
        <div id="path">
            <p>Accounting Workflow Demo</a></p>
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
            <div class="hallinta">

                <br/>

                <!-- 
                    PIIRRÄ KUUKAUDEN LUONTI GUI OSA HTML
                -->

                        <h4>Tällä luodaan uusi seurantakuukausi kaikille seurattaville yrityksille</h4>
                        <table id="luokuukausi">
                            <tr><td>Vuosi</td><td>Kuukausi</td></tr>

                            <tr>
                                <td><?php echo $seuraavavuosi ?></td><td><?php echo $seuraavakk ?></td>
                                <td>
                                    <form class="GUI_form" action="" method="post">
                                        <input type='hidden' name='vuosi' value='<?php echo $seuraavavuosi ?>'/>
                                        <input type='hidden' name='seuraavakuukausi' value='<?php echo $seuraavakk ?>'/>
                                        <?php if (!$next_year_true) : ?><input type='submit' name='luokuukausi' value='LUO KUUKAUSI'/>
                                        <?php elseif($next_year_true) : ?> <input type='submit' name='luovuosi' value='AVAA VUOSI'/><?php endif ?>
                                    </form>
                                </td>
                            </tr>
                        </table>
                
            </div>

            <!--
                VALIKOT YKSITTÄISEN KUUKAUDEN LUOMISEEN
            -->
            <div class="hallinta">
                <h4>Tällä lisäät kuukausiseurantaa yksittäisen asiakkaan tietyn kuukauden</h4>
                <h4>Asiakas täytyy olla perustettuna rekisteriin, jotta se näkyy listalla</h4>
                <select form="valitseasiakas" name="kuukausilista">        
                    <?php
                        foreach (range(1,12,1) as $kuukausi){
							// Päättele custom 'AS' taulukon nimi
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
                            <option value="<?php echo $kuukausi ?>"><?php echo $kuukausi_nimi ?></option>
                        <?php } ?>
                </select>
                <select form="valitseasiakas" name="vuosilista">        
                    <?php foreach ( array_reverse($kaikki_vuodet) as $vuosi){ ?>
                            <option value="<?php echo $vuosi ?>"><?php echo $vuosi ?></option>
                    <?php } ?>
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
                
            </div>  
                

            <!--
                VALIKOT ASIAKKAAN LUOMISEKSI REKISTERIIN
            -->
            <div class="hallinta">
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
                
            </div>
        </section>

        
        <script type="text/javascript" src="jquery-1.11.3.min.js"></script>

    </body>
</html>
