<?php
	
	session_start();
		
    if( isset($_POST['logout']) )
    {
        session_destroy();
        header("Refresh:0");
    }

    if( isset($_SESSION['authenticate']) ) {
        
            // SESSION ON LUOTU, EI TARKISTETA LOGIN TUNNUKSIA
        
            // MUOKKAA TÄHÄN KÄYTTÄJÄTUNNUKSET TARKISTUSTA VARTEN
			// TÄLLÄ HETKELLÄ KIINTEÄT TARKISTUKSET, MUUTETTAVA JOS ENEMMÄN KÄYTTÄJIÄ
            if ( $_SESSION['authenticate'] != 'someuser1' && $_SESSION['authenticate'] != 'someuser2' )
            {
                // HUONO SESSION, TUHOTAAN
                session_destroy();
                die('Bad authentication credentials, contact webmaster');
            }
    }

    elseif( isset($_POST['user']) && isset($_POST['pass']) )
    {

            // EI SESSIOTA, LOGIN POST LÄHETETTY, TARKISTETAAN KÄYTTÄJÄT
            $db_host = 'localhost';
            $db_user = 'root';
            $db_pwd = '';
            $db = 'credentials_database';
            $tbl = 'users_table';
            $loginusername = $_POST['user'];
            $loginpassword = sha1($_POST['pass']);

            $connection = mysql_connect("$db_host", "$db_user", "$db_pwd")or die("cannot connect");
        
            mysql_select_db("$db") or die("Unable to select database");

            $sql="SELECT * FROM $tbl WHERE username='$loginusername' AND password='$loginpassword'";

            $result = mysql_query($sql);

            // Count how many results were pulled from the table
            $count = mysql_num_rows($result);

            // If the result equals 1 login was correct
            if($count == 1)
            {

                $_SESSION['authenticate'] = $loginusername;

            }

            // WRONG USERNAME OR PASSWORD
            else
            {
                session_destroy();
                echo 
                '<form action="" method="post">
                User: <input type="text" name="user"><br>
                Password: <input type="password" name="pass"><br>
                <input type="submit">
                </form>';
                die('Wrong username or password');
            }

            mysql_free_result($result);
            mysql_close($connection);
    }

    // NO LOGIN INPUT DETECTED YET
	// NÄYTETÄÄ KIRJAUTUMISIKKUNA EIKÄ MUUTA
    else
    {
        session_destroy();
        echo 
        '<form action="" method="post">
        User: <input type="text" name="user"><br>
        Password: <input type="password" name="pass"><br>
        <input type="submit">
        </form>';
        die('Login to continue');
    }
?>