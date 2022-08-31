<?php 
    session_start();

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



    /* ----------------------- GET THE CURRENT USER LOGGED IN ------------------------------- */
    if (isset($_POST['login_btn'])) {

        $username = mysqli_real_escape_string($connection_db, $_POST['username']);
        $password = mysqli_real_escape_string($connection_db, $_POST['password']);

        $query = "SELECT * FROM registration WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($connection_db, $query);
        if (mysqli_num_rows($results) == 1) {
            // check if user is admin or user
            $logged_in_user = mysqli_fetch_assoc($results);

            if ($logged_in_user['user_type'] == 'admin') {
            $_SESSION['user'] = $logged_in_user;
            }

            if ($logged_in_user['user_type'] == 'user'){
                $_SESSION['user'] = $logged_in_user;
            }
            
        }
    }
    /* ----------------------- /GET THE CURRENT USER LOGGED IN ------------------------------- */
    
  ?>