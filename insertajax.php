
<?php
    /*
     *          SYÖTÄ ARVO KUUKAUSISEURANTAAN
     *          arvot lähetetään ajaxquery.js tiedoston ajax-komennolla
     */

    include 'init.php';

    if ( isset($_POST['ajaxrow']) ) 
    {
        $editrow = ($_POST['ajaxrow']);
        $editcolumn = ($_POST['ajaxcol']);
        $newvalue = ($_POST['newvalue1']);

        $incolumn = $editcolumn;

        // curdate used for empty fields automatic input
        $curdate = date('Y-m-d');

        // Set empty value in field as current date
        // Checks each custom named columns for match, strpos returns false (notice '===' check)if string isn't found
        if (empty($_POST['newvalue1']) && strpos($editcolumn, "EU") !== false) 
        {
            $sql = "UPDATE `$seuranta` SET EU='$curdate' WHERE Rivi=$editrow";
            $incolumn = "EU";
        }
        elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "ALV") !== false) 
        {
            $sql = "UPDATE $seuranta SET ALV='$curdate' WHERE Rivi=$editrow";
            $incolumn = "ALV";
        }
        elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "TAS") !== false) 
        {
            $sql = "UPDATE $seuranta SET TAS='$curdate' WHERE Rivi=$editrow";
            $incolumn = "TAS";
        }
        elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "TYEL") !== false)
        {
            $sql = "UPDATE $seuranta SET TYEL='$curdate' WHERE Rivi=$editrow";
            $incolumn = "TYEL";
        }
        elseif (empty($_POST['newvalue1']) && strpos($editcolumn, "Rak. Ilm.") !== false)
        {
            $sql = "UPDATE $seuranta SET `Rakentamis`='$curdate' WHERE Rivi=$editrow";
            $incolumn = "Rakentamis";
        }

        // This means there was a value, if value is 'null' then erase field
        // Checks each custom column for match, strpos returns false if string isn't found
        elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "EU") !== false) 
        {
            if (strpos($newvalue, "null") !== false)
            {
                $sql = "UPDATE $seuranta SET EU= NULL WHERE Rivi=$editrow";  
            }
            else
            {
                $sql = "UPDATE $seuranta SET EU='$newvalue' WHERE Rivi=$editrow";
            }

            $incolumn = "EU";
        }
        elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "ALV") !== false) 
        {
            if (strpos($newvalue, "null") !== false)
            {
                $sql = "UPDATE $seuranta SET ALV= NULL WHERE Rivi=$editrow";  
            }
            else
            {
                $sql = "UPDATE $seuranta SET ALV='$newvalue' WHERE Rivi=$editrow";
            }

            $incolumn = "ALV";
        }
        elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "TAS") !== false) 
        {
            if (strpos($newvalue, "null") !== false)
            {
                $sql = "UPDATE $seuranta SET TAS= NULL WHERE Rivi=$editrow";  
            }
            else
            {
                $sql = "UPDATE $seuranta SET TAS='$newvalue' WHERE Rivi=$editrow";
            }

            $incolumn = "TAS";
        }
        elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "TYEL") !== false)
        {
            if (strpos($newvalue, "null") !== false)
            {
                $sql = "UPDATE $seuranta SET TYEL= NULL WHERE Rivi=$editrow";  
            }
            else
            {
                $sql = "UPDATE $seuranta SET TYEL='$newvalue' WHERE Rivi=$editrow";
            }

            $incolumn = "TYEL";
        }
        elseif (!empty($_POST['newvalue1']) && strpos($editcolumn, "Rak. Ilm.") !== false)
        {
            if (strpos($newvalue, "null") !== false)
            {
                $sql = "UPDATE $seuranta SET `Rakentamis`= NULL WHERE Rivi=$editrow";  
            }
            else
            {
                $sql = "UPDATE $seuranta SET `Rakentamis`='$newvalue' WHERE Rivi=$editrow";   
            }

            $incolumn = "Rakentamis";
        }

        // Not a custom 'AS' column, insert value directly
        elseif (empty($_POST['newvalue1']))
        {
            $sql = "UPDATE $seuranta SET `$editcolumn`='$curdate' WHERE Rivi=$editrow";
        }
        else
        {
            if (strpos($newvalue, "null") !== false)
            {
                $sql = "UPDATE $seuranta SET `$editcolumn`= NULL WHERE Rivi=$editrow";  
            }
            else
            {
                $sql = "UPDATE $seuranta SET `$editcolumn`='$newvalue' WHERE Rivi=$editrow";   
            }
        }

        // Make Query
        $update_seuranta_return = mysql_query($sql);

        if (!$update_seuranta_return)
        {
            echo "FAIL";
            die('Koodi 1. Virhe syötössä: ' . mysql_error());
        }
        else
        {
            $sql_ret = "SELECT `$incolumn` FROM $seuranta WHERE Rivi=$editrow";

            $ret_val = mysql_query($sql_ret);

            $return = mysql_fetch_row($ret_val);

            if ( sizeof($return) < 1 )
            {
                echo "FAIL: uuden arvon nouto epäonnistui";
            }
            else    
            {
                echo $return[0];
            }
            
            mysql_free_result($ret_val);
        }
    }
?>