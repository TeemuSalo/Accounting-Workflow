<?php

    include 'init.php';

    if ( isset($_POST['ajaxrow']) )
    {
        /*
         *          SYÖTÄ ARVO ASIAKASREKISTERIIN
         */

        $curdate = date('Y-m-d');
        
        $rek_editrow = ($_POST['ajaxrow']);
        $rek_editcolumn = ($_POST['ajaxcol']);
        $rek_newvalue = ($_POST['newvalue2']);
        
        if( $rek_newvalue == '' ) $rek_newvalue = $curdate;

        if( $rek_newvalue == 'null' )
        {
            $sql = "UPDATE $rekisteri SET `$rek_editcolumn` = NULL WHERE Rivi=$rek_editrow";
        }
        
        else
        {
            $sql = "UPDATE $rekisteri SET `$rek_editcolumn` = '$rek_newvalue' WHERE Rivi=$rek_editrow";
        }
        
        $rek_update_return = mysql_query($sql);
        
        if (!$rek_update_return)
        {
            echo 'virhe';
            die('Koodi 22. Virhe yhteydessä tietokantaan: ' . mysql_error());
        }
        else
        {
            $sql = "SELECT `$rek_editcolumn` FROM `$rekisteri` WHERE Rivi=$rek_editrow";
            
            $ret_val = mysql_query($sql);

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

    else
    {
        /*
         *          PIIRRÄ ASIAKASREKISTERI OSA 1
         */

        $draw_rek_return = mysql_query("SELECT * FROM $rekisteri ORDER BY Asiakas");

        if (!$draw_rek_return) 
        {
            echo $takaisin_seurantaan;
            die('Koodi 23. Virhe yhteydessä tietokantaan: ' . mysql_error());
        }

        $rek_fields_num = mysql_num_fields($draw_rek_return); 
    }
?>