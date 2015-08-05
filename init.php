<?php
// PHP INIT.php
session_start();
$db_host = 'localhost';
$db_user = 'root';
$db_pwd = '';
$database = 'jp_asiakkaat';

$rekisteri = 'testi_asiakasrek';    // HUOM TESTI DATABASE
$seuranta = 'testi_kuukausi';       // HUOM TESTI DATABASE

$takaisin_seurantaan = '<a href="seuranta.php">TAKAISIN</a><br/><br/>';
$takaisin_hallintaan = '<a href="hallinta.php">TAKAISIN</a><br/><br/>';

if (isset($_SESSION['selected_month']))
{
    $valittu_kuukausi = $_SESSION['selected_month'];
}

$conn = mysql_connect($db_host, $db_user, $db_pwd);
if (!$conn)
    die("Can't connect to database");

if (!mysql_select_db($database))
    die("Can't select database");

mysql_query("SET NAMES 'utf8'");

?>