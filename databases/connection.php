<?php 
    /* ---------------------- CONNECT TO THE DATABASE -------------------------------------- */
    $db_hostname = 'localhost';
    $db_name = 'web_project';
    $db_username = 'root';
    $db_password = '';

    try{
        $connection_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    } catch (Exception $e) {
        echo "Connection Failed" .$e->getMessage();
    }
    /* ----------------------- /CONNECT TO THE DATABASE ------------------------------------- */
    
  ?>