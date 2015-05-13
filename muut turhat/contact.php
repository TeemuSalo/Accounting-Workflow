<?php $name = $_POST['name'];
$email = $_POST['email'];
$puh = $_POST['puh'];
$message = $_POST['message'];
$formcontent="Nimi: $name \n 
Email: $email \n 
Puhelin: $puh \n
 Viesti: $message";
$recipient = "posti@jptilit.fi";
$subject = "Jp-tilit.fi Yhteydenotto";
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "<h3>Kiitos yhteydenotosta!</h3>";
echo "<a href=\"index.html\">Takaisin sivustolle</a>"
?>
 