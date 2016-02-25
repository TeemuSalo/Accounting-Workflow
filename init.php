<?php
// INIT MYSQL yhteys ym. aloitusmuuttujat

// Authentication.php aloittaa sessionit, jos se lisätty
// Huom, muuten session_start() täytyy lisätä erikseen ennen init.php tiedostoa

$db_host = 'localhost';
$db_user = 'root';
$db_pwd = '';
$database = 'database_name';

$rekisteri = 'registry_name';         		// DATABASE FOR CUSTOMER REGISTER

$seuranta_prefix = 'seuranta_';             // DATABASE FOR WORKFLOW TABLE PREFIX

$takaisin_seurantaan = '<a href="seuranta.php">TAKAISIN</a><br/><br/>';
$takaisin_hallintaan = '<a href="hallinta.php">TAKAISIN</a><br/><br/>';


if ( isset($_SESSION['selected_year']) ) // Tämä saattaa olla turha, pitää tarkistaa
{
    $seuranta_suffix = $_SESSION['selected_year']; // Tämä saattaa olla turha, pitää tarkistaa
}
else
{
    $seuranta_suffix = date('Y'); // Tämä saattaa olla turha, pitää tarkistaa
}

$seuranta = $seuranta_prefix . $seuranta_suffix; // Tämä saattaa olla turha, pitää tarkistaa

$conn = mysql_connect($db_host, $db_user, $db_pwd);

if ( !$conn ) die("Can't connect to database");

if ( !mysql_select_db($database) ) die("Can't select database");

mysql_query("SET NAMES 'utf8'");

$aloitusvuosi = 2015; 		// ALOITUSVUOSI, HUOM MUUTTUMATON, PITÄÄ MÄÄRITTÄÄ PER KÄYTTÄJÄ
$kaikki_vuodet = array();

// Hanki kaikki perustetut vuodet listaan
while( mysql_query('SELECT 1 FROM `' . $seuranta_prefix . $aloitusvuosi . '` LIMIT 1') )
{
    $kaikki_vuodet[] = $aloitusvuosi;
    $aloitusvuosi++;
}

?>
