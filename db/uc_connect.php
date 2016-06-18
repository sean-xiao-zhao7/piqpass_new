<?php

	$mysqli_piq = new mysqli($db_host_piq, $db_user_piq, $db_pass_piq, $db_name_piq);
        //GLOBAL $mysqli_piq;

        if(mysqli_connect_errno()) {
                echo "Connection Failed: " . mysqli_connect_errno();
                exit();
        }

?>
