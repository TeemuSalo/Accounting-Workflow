<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
            <a href=""><img src="jplogo.jpg"></img></a>
            <ul>
                <a href="index.html"><li id="etusivu">Etusivu</li></a>
                <a href="palvelut.html"><li id="palvelut">Palvelut</li></a>
                <a href="hintalaskuri.html"><li id="hintalaskuri">Hintalaskuri</li></a>
                <a href="yhteystiedot.html"><li id="yhteystiedot">Yhteystiedot</li></a>
            </ul>
        </nav>

        <div id="path"><p><a href="index.html">Etusivu</a> > <a href="mysql_test.php">MySQL testisivu</a></p></div>








        <section>
            <article id="kirjanpito">

                <br/>
                <select form="vaihdakuukausi" name="kuukausilista">
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
                    <input type='submit' name='vaihdakk' value='Vaihda'/>
                </form>


                <?php
                /*
                 *   PHP Chance values in kuukausiseuranta
                 */

                if (isset($_POST['insertkk'])) {

                    $db_host = 'localhost';
                    $db_user = 'root';
                    $db_pwd = '';

                    $database = 'test';
                    $table = 'kkseuranta';

                    $editrow = ($_POST['row1']);
                    $editcolumn = ($_POST['column1']);
                    $newvalue = ($_POST['newvalue1']);

                    $conn = mysql_connect($db_host, $db_user, $db_pwd);
                    if (!$conn)
                        die("Can't connect to database");

                    if (!mysql_select_db($database))
                        die("Can't select database");

                    mysql_query("SET NAMES 'utf8'");

                    // sending query
                    if (empty($_POST['newvalue1']) && ($editcolumn == "ALV" || "TAS" || "TYEL" || "Sähköposti")){
                    $curdate = date('Y-m-d');
                    $sql = "UPDATE {$table} SET $editcolumn='$curdate' WHERE ID='$editrow'";
                    }else{
                    $sql = "UPDATE {$table} SET $editcolumn='$newvalue' WHERE ID='$editrow'";
                    }

                    $retval = mysql_query($sql, $conn);
                    if (!$retval) {
                        die('Could not update data: ' . mysql_error());
                    }
                }
                ?>



                <?php
                /*
                 *   PHP Draw values in kuukausiseuranta
                 */

                $db_host = 'localhost';
                $db_user = 'root';
                $db_pwd = '';

                $database = 'test';
                $table = 'kkseuranta';

                $conn = mysql_connect($db_host, $db_user, $db_pwd);
                if (!$conn)
                    die("Can't connect to database");

                if (!mysql_select_db($database))
                    die("Can't select database");

                mysql_query("SET NAMES 'utf8'");

                // sending query
                //Kuukausi valittu
                if (isset($_POST['vaihdakk'])) {

                    $kuukausi = $_POST['kuukausilista'];
                    
                    $nextmonth = 2 + intval($kuukausi);
                    $payday = '12.'.$nextmonth.'.'.date('Y');
                    
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
                    };


                    $retval = mysql_query("SELECT "
                            . "ID,"
                            . "Asiakas,"
                            . "ALV AS 'ALV $ALV_month', "
                            . "TAS AS 'TAS $TAS_month', "
                            . "TYEL AS 'TYEL $TAS_month',"
                            . "Sähköposti,"
                            . "Kommentit "
                            . "FROM {$table} "
                            . "WHERE kuukausi = '$kuukausi'");
                            
                    if (!$retval) {
                        die('Could not update data: ' . mysql_error());
                    }

                    $fields_num = mysql_num_fields($retval);

                    echo "<h4>Table: {$table} $ALV_month</h4> <h4 style='float:right;'> Maksupäivä $payday</h4>";
                    echo "<table border='1'><tr>\n";
                    // printing table headers
                    for ($i = 0; $i < $fields_num; $i++) {
                        $field = mysql_fetch_field($retval);
                        //echo "<td><p>$field->name : </p><input name='$field->name' type='text' size='21'/></td>";
                        echo "<td>{$field->name}</td>";
                        $column[$i] = $field->name;
                    }

                    echo "</tr>\n";
                    // printing table rows
                    while ($row = mysql_fetch_row($retval)) {
                        echo "<tr>";
                        // $row is array... foreach( .. ) puts every element
                        // of $row to $cell variable
                        $iterator = 0;
                        foreach ($row as $cell) {
                            $col = $column[$iterator];
                            $id = $row[0] . $col;
                            echo
                            "<td>
                            <div id=\"$id show1\">$cell 
                            <button onclick=\"return editkausi('$id', '$cell')\">X</button>
                            </div>
                            <div id=\"$id hide1\" style='display:none'>
                            <button onclick=\"return canceleditkausi('$id', '$cell')\">EI</button>
                            <form id=\"$id seuranta\" action='' method='post'>
                            <input value=\"{$row[0]}\" name='row1' type='hidden'/>
                            <input value=\"$col\" name='column1' type='hidden'/>
                            <input name='newvalue1' type='text' size='20'/>
                            <input type='submit' name='insertkk' value='OK'/>
                            </form>
                            </div>
                            </td>";
                            $iterator++;
                        }
                        echo "</tr>\n";
                    }
                    echo "</table>\n";
                    mysql_free_result($retval);
                }

                //Aloitus tai ei valittua kuukautta
                else {

                    $nextmonth = 1 + intval(date('n'));
                    $payday = '12.'.$nextmonth.'.'.date('Y');
                    
                    $this_month = date('n');
                    $TAS_month = $this_month;
                    $ALV_month = $this_month - 1;
                    
                    switch ($ALV_month) {
                        case 0:
                            $ALV_month = 'joulukuu';
                            $TAS_month = 'tammikuu';
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
                            $ALV_month = 'joulukuu';
                            $TAS_month = 'tammikuu';
                            break;
                        case 7:
                            $ALV_month = 'joulukuu';
                            $TAS_month = 'tammikuu';
                            break;
                        case 8:
                            $ALV_month = 'joulukuu';
                            $TAS_month = 'tammikuu';
                            break;
                    };

                    $result = mysql_query("SELECT "
                            . "ID,"
                            . "Asiakas,"
                            . "ALV AS 'ALV $ALV_month', "
                            . "TAS AS 'TAS $TAS_month', "
                            . "TYEL AS 'TYEL $TAS_month',"
                            . "Sähköposti,"
                            . "Kommentit "
                            . "FROM {$table}");
                            
                    if (!$result) {
                        die("Query to show fields from table failed");
                    }
                    $fields_num = mysql_num_fields($result);

                    echo "<h4>Table: {$table} $ALV_month</h4> <h4 style='float:right;'> Maksupäivä $payday</h4>";
                    echo "<table border='1'><tr>\n";
                    // printing table headers
                    for ($i = 0; $i < $fields_num; $i++) {
                        $field = mysql_fetch_field($result);
                        echo "<td>{$field->name}</td>";
                        $column[$i] = $field->name;
                    }
                    echo "</tr>\n";
                    // printing table rows
                    while ($row = mysql_fetch_row($result)) {
                        echo "<tr>";
                        // $row is array... foreach( .. ) puts every element
                        // of $row to $cell variable
                        $iterator = 0;
                        foreach ($row as $cell) {
                            $col = $column[$iterator];
                            $id = $row[0] . $col;
                            echo
                            "<td>
                            <div id=\"$id show1\">$cell 
                            <button onclick=\"return editkausi('$id', '$cell')\">X</button>
                            </div>
                            <div id=\"$id hide1\" style='display:none'>
                            <button onclick=\"return canceleditkausi('$id', '$cell')\">EI</button>
                            <form id=\"$id seuranta\" action='' method='post'>
                            <input value=\"{$row[0]}\" name='row1' type='hidden'/>
                            <input value=\"$col\" name='column1' type='hidden'/>
                            <input name='newvalue1' type='text' size='20'/>
                            <input type='submit' name='insertkk' value='OK'/>
                            </form>
                            </div>
                            </td>";
                            $iterator++;
                        }
                        echo "</tr>\n";
                    }
                    echo "</table>\n";
                    mysql_free_result($result);
                }
                ?>


                <script>
                    function editkausi(id, solu) {

                        var shownelement = document.getElementById(id + ' show1');
                        shownelement.style.display = "none";

                        var Form = document.forms[id + ' seuranta'];
                        Form.elements['newvalue1'].value = solu;
                        var hiddenelement = document.getElementById(id + ' hide1');
                        hiddenelement.style.display = "";

                        return false;
                    }
                </script>

                <script>
                    function canceleditkausi(id, solu) {

                        var shownelement = document.getElementById(id + ' show1');
                        shownelement.style.display = "";

                        var hiddenelement = document.getElementById(id + ' hide1');
                        hiddenelement.style.display = "none";

                        return false;
                    }
                </script>


                <br/><br/><br/><br/>
                <!--
                -
                -
                TAULUKKO VAIHTUU
                -
                -
                -->			
                <?php
                /*
                 *   PHP Chance values in asiakasrekisteri
                 */

                if (isset($_POST['insertrek']) && !empty($_POST['newvalue2'])) {

                    $db_host = 'localhost';
                    $db_user = 'root';
                    $db_pwd = '';

                    $database = 'test';
                    $table = 'asiakasrekisteri';

                    $editrow = ($_POST['row2']);
                    $editcolumn = ($_POST['column2']);
                    $newvalue = ($_POST['newvalue2']);

                    $conn = mysql_connect($db_host, $db_user, $db_pwd);
                    if (!$conn)
                        die("Can't connect to database");

                    if (!mysql_select_db($database))
                        die("Can't select database");

                    mysql_query("SET NAMES 'utf8'");

                    // sending query

                    $sql = "UPDATE {$table} SET $editcolumn='$newvalue' WHERE ID='$editrow'";

                    $retval = mysql_query($sql, $conn);
                    if (!$retval) {
                        die('Could not update data: ' . mysql_error());
                    }
                }
                ?>



                <?php
                /*
                 *   PHP Draw values in asiakasrekisteri
                 */

                $db_host = 'localhost';
                $db_user = 'root';
                $db_pwd = '';

                $database = 'test';
                $table = 'asiakasrekisteri';

                $conn = mysql_connect($db_host, $db_user, $db_pwd);
                if (!$conn)
                    die("Can't connect to database");

                if (!mysql_select_db($database))
                    die("Can't select database");

                mysql_query("SET NAMES 'utf8'");

                // sending query
                /*
                  if (isset($_POST['update'])) {

                  $yritys = $_POST['yritys'];
                  $tilikausi = $_POST['tilikausi'];
                  $tilinpäätös = $_POST['tilinpäätös'];
                  $luokitus = $_POST['luokitus'];

                  $sql = "SELECT * FROM {$table} WHERE yritys LIKE '%$yritys%' " ;

                  $retval = mysql_query($sql, $conn);
                  if (!$retval) {
                  die('Could not update data: ' . mysql_error());
                  }

                  $fields_num = mysql_num_fields($retval);

                  echo "<h4>Table: {$table} Search</h4>";
                  echo "<table border='1'><tr>\n";
                  // printing table headers
                  for ($i = 0; $i < $fields_num; $i++) {
                  $field = mysql_fetch_field($retval);
                  echo "<td><p>$field->name : </p><input name='$field->name' type='text' size='21'/></td>";
                  //echo "<td>{$field->name}</td>";
                  }

                  echo "</tr>\n";
                  // printing table rows
                  while ($row = mysql_fetch_row($retval)) {
                  echo "<tr>";
                  // $row is array... foreach( .. ) puts every element
                  // of $row to $cell variable
                  foreach ($row as $cell)
                  echo "<td>$cell</td>";

                  echo "</tr>\n";
                  }
                  echo "</table>\n";
                  mysql_free_result($retval);
                  }
                  else { */
                $result = mysql_query("SELECT * FROM {$table}");
                if (!$result) {
                    die("Query to show fields from table failed");
                }
                $fields_num = mysql_num_fields($result);

                echo "<h4>Table: {$table}</h4>";
                echo "<table border='1'><tr>\n";
                // printing table headers
                for ($i = 0; $i < $fields_num; $i++) {
                    $field = mysql_fetch_field($result);
                    echo "<td>{$field->name}</td>";
                    $column[$i] = $field->name;
                }
                echo "</tr>\n";
                // printing table rows
                while ($row = mysql_fetch_row($result)) {
                    echo "<tr>";
                    // $row is array... foreach( .. ) puts every element
                    // of $row to $cell variable
                    $iterator = 0;
                    foreach ($row as $cell) {
                        $col = $column[$iterator];
                        $id = $row[0] . $col;
                        echo
                        "<td>
                            <div id=\"$id show2\">$cell 
                            <button onclick=\"return editasiakas('$id', '$cell')\">X</button>
                            </div>
							<div id=\"$id hide2\" style='display:none'>
                            <button onclick=\"return canceledit('$id', '$cell')\">EI</button>
							<form id=\"$id rek\" action='' method='post'>
                            <input value=\"{$row[0]}\" name='row2' type='hidden'/>
                            <input value=\"$col\" name='column2' type='hidden'/>
                            <input name='newvalue2' type='text' size='20'/>
                            <input type='submit' name='insertrek' value='OK'/>
                            </form>
                            </div>
                            </td>";
                        $iterator++;
                    }
                    echo "</tr>\n";
                }
                echo "</table>\n";
                mysql_free_result($result);
                //}
                ?>             

                <script>
                    function editasiakas(id, solu) {

                        var shownelement = document.getElementById(id + ' show2');
                        shownelement.style.display = "none";

                        var Form = document.forms[id + ' rek'];
                        Form.elements['newvalue2'].value = solu;
                        var hiddenelement = document.getElementById(id + ' hide2');
                        hiddenelement.style.display = "";

                        return false;
                    }
                </script>

                <script>
                    function canceledit(id, solu) {

                        var shownelement = document.getElementById(id + ' show2');
                        shownelement.style.display = "";

                        var hiddenelement = document.getElementById(id + ' hide2');
                        hiddenelement.style.display = "none";

                        return false;
                    }
                </script>



            </article>
        </section>








        <aside>
            <ul>

            </ul>
        </aside>
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
        <!--<div id="map-canvas"></div>-->
        <!--
</section>			
</div>
</footer>
        -->
    </body>
</html>