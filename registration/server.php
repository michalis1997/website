<!-- In this file server.php will receive information submitted from the form and store (register) the information in the database. -->
<?php

  session_start();

  // initializing variables
  $username = "";
  $email    = "";
  $errors = array(); 


  /* ---------------------- CONNECT TO THE DATABASE --------------------------------- */
  $db_hostname = 'localhost';
  $db_name = 'web_project';
  $db_username = 'root';
  $db_password = '';

  try{
      $connection_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
  } catch (Exception $e) {
      echo "Connection Failed" .$e->getMessage();
  }
  /* ----------------------- /CONNECT TO THE DATABASE ------------------------------- */



  /* ----------------------------- REGISTER USER ------------------------------------ */
  if (isset($_POST['register_btn'])) {
  
    // receive all input values from the form with POST method
    $username = mysqli_real_escape_string($connection_db, $_POST['username']);
    $email = mysqli_real_escape_string($connection_db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($connection_db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($connection_db, $_POST['password_2']);
    
    // form validation: ensure that the form is correctly filled by adding (array_push()) corresponding error into $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

    // return user array from their id
    function getUserById($id) {
        global $connection_db;
        //Use try catch exception if select query fails.
        try{
        $query = "SELECT * FROM registration WHERE id=" .$id;
        } catch (Exception $e) {
          echo "Select Query Failed" .$e->getMessage();
        }
        $result = mysqli_query($connection_db, $query );

        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    if (count($errors) == 0) {
      //encrypt the password before saving in the database
      $password = md5($password_1);
      
      if (isset($_POST['user_type'])) {
        $user_type = mysqli_real_escape_string($connection_db, $_POST['user_type']);
        $query = "INSERT INTO registration (username, email, user_type, password) 
                  VALUES('$username', '$email', 'admin', '$password')";
        mysqli_query($connection_db, $query);
        $_SESSION['success']  = "New user successfully created!!";
        header('location: home.php');
      } else {
        $query = "INSERT INTO registration (username, email, user_type, password) 
                  VALUES('$username', '$email', 'user', '$password')";
        mysqli_query($connection_db, $query);

        // get id of the created user
        $logged_in_user_id = mysqli_insert_id($connection_db);

        $_SESSION['user'] = getUserById($logged_in_user_id); 
        $_SESSION['success']  = "You are now logged in";
        header('location: index.php');
      }
    }
  }
  /* ----------------------------- /REGISTER USER ------------------------------------ */


  /* ------------------------------- LOGIN USER -------------------------------------- */
  if (isset($_POST['login_btn'])) {

    $username = mysqli_real_escape_string($connection_db, $_POST['username']);
    $password = mysqli_real_escape_string($connection_db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM registration WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($connection_db, $query);

        if (mysqli_num_rows($results) == 1) {
            // check if user is admin or user
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($logged_in_user['user_type'] == 'admin') {
              $_SESSION['user'] = $logged_in_user;
              $_SESSION['success']  = "You are now logged in";
              header('location: admin/home.php');		
                
            }else 

            if ($logged_in_user['user_type'] == 'user'){
              $_SESSION['user'] = $logged_in_user;
              $_SESSION['success']  = "You are now logged in";
              header('location: index.php');
            } 
          }else {
            array_push($errors, "Wrong username/password combination");
          }
    }
  }
  /* ------------------------------- /LOGIN USER -------------------------------------- */


  // Function that checks if the user is admin
  function isAdmin() {
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
      return true;
    } else {
      return false;
    }
  }

  function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
  }

/* ----------------- CHANGE PROFILE USERNAME / PASSWORD (profile.php) ------------------- */
  $row='';
  $Row='';

  if (isset($_POST['submit'])){

    $curUsername = $_POST['curUsername'];
    $curPassword = md5($_POST['curPassword']);
    $newUsername = $_POST['newUsername'];
    $newPassword = md5($_POST['newPassword']);
    $repeatNewPassword = md5($_POST['repeatNewPassword']);

    if (empty($curUsername)) { array_push($errors, "Username is required"); }
    if (empty($curPassword)) { array_push($errors, "Password is required"); }
    if (empty($newUsername)) { array_push($errors, "Username is required"); }
    if (empty($newPassword)) { array_push($errors, "Password is required"); }
    if (empty($repeatNewPassword)) { array_push($errors, "Password is required"); }
    if ($newPassword != $repeatNewPassword) { array_push($errors, "The two passwords don't match"); }

    $query =  "SELECT username,password FROM registration WHERE username ='$curUsername' AND password='$curPassword' ";
    $result = mysqli_query($connection_db, $query);
    $row = mysqli_fetch_assoc($result);

    $query =  "SELECT username FROM registration WHERE username = '$newUsername' ";
    $Result = mysqli_query($connection_db, $query);
    $Row = mysqli_fetch_assoc($Result);

    // if = true when row>0 (when exists same username&password as before) AND Row=null(when doesn't exists same username as the new one in db
    if  ( ($row>0) && ($Row == null) ){
      $queryUpdate = "UPDATE registration SET password='$newPassword' , username='$newUsername' WHERE username='$curUsername' AND password='$curPassword' "; 
      mysqli_query($connection_db, $queryUpdate);
      
      $message = "Your username/password has been changed successfully";
      echo "<script type='text/javascript'> alert('$message'); </script>"; 
    } else {
      array_push($errors, " Username already exists. Please try with another one. " );
    }

    $Row = null;


}
/* ----------------- /CHANGE PROFILE USERNAME / PASSWORD (profile.php) ------------------- */

mysqli_close($connection_db);
?>