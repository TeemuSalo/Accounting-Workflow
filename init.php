<?php
// INIT MYSQL yhteys ym. aloitusmuuttujat

session_start();

$db_host = 'localhost';
$db_user = 'username';
$db_pwd = 'password';
$database = 'database_name';

$rekisteri = 'registry_table';         			// DATABASE FOR CUSTOMER REGISTER

$seuranta_prefix = 'workflow_prefix';                 // DATABASE FOR WORKFLOW TABLE PREFIX

$takaisin_seurantaan = '<a href="seuranta.php">TAKAISIN</a><br/><br/>';
$takaisin_hallintaan = '<a href="hallinta.php">TAKAISIN</a><br/><br/>';


if ( isset($_SESSION['selected_year']) )
{
    $seuranta_suffix = $_SESSION['selected_year'];
}
else
{
    $seuranta_suffix = date('Y');
}

$seuranta = $seuranta_prefix . $seuranta_suffix;

$conn = mysql_connect($db_host, $db_user, $db_pwd);

if ( !$conn ) die("Can't connect to database");

if ( !mysql_select_db($database) ) die("Can't select database");

mysql_query("SET NAMES 'utf8'");

$aloitusvuosi = 2015; 			// ALOITUSVUOSI, HUOM MUUTTUMATON, PITÄÄ MÄÄRITTÄÄ PER KÄYTTÄJÄ
$kaikki_vuodet = array();

// Hanki kaikki perustetut vuodet listaan
while( mysql_query('SELECT 1 FROM `' . $seuranta_prefix . $aloitusvuosi . '` LIMIT 1') )
{
    $kaikki_vuodet[] = $aloitusvuosi;
    $aloitusvuosi++;
}

?>
