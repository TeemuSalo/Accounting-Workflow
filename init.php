<?php
// PHP INIT.php
session_start();
$db_host = 'localhost';
$db_user = 'user123';
$db_pwd = 'password';
$database = 'abc_workflowdatabase';

$rekisteri = 'zxc_registertable';       // DATABASE FOR CUSTOMER REGISTER
$seuranta = 'zxc_workflowtable';        // DATABASE FOR WORKFLOW TABLE

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
