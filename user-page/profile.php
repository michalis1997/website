<?php   
    include('../../registration/server.php');
    $userID =  $_SESSION['user']['id'];

    // If the user is not logged in and tries to access this page, they are automatically redirected to the login page. 
    if (!isset($_SESSION['user'])) {
      $_SESSION['msg'] = "You must log in first";
      header('Location: ../../registration/login.php');
    }
  
    // Checks if the user has clocked the logout button. If yes, the system logs them out and redirects them back to the login page.
    if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['user']);
      header('Location: ../../registration/login.php');
    }
  
?>

<!DOCTYPE html>
<html lang="el">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <!-- Setting the viewport to make your website look good on all devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Libraries CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../design.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
 
</head>

<body style="background-color: #fafafa;">

  <!-- Navigation Bar  -->
  <div class="container pb-5">
    <nav class="navbar fixed-top navbar-expand-md navbar-light" style="background-color: rgb(35, 89, 116)" >
    
      <a href="user_app.php"><img src="../images/logo.png"/></a>
      
      <!-- dropdown toggler when screen size is too small -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- /dropdown toggler when screen size is too small -->

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto navbar-spacing mr-3" >
          <li class="nav-item active pr-2" >
            <a class="nav-link text-light" href="user_app.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
          </li>

          <li class="nav-item active pl-2" >
            <a class="nav-link text-light" href="about_us/about_us.php"><i class="fa fa-users" aria-hidden="true"></i> About</a>
          </li>

          <li class="nav-item active pl-2" >
            <a class="nav-link text-light" href="contact_us/contact_us.php"><i class="fa fa-envelope" aria-hidden="true"></i> Contact</a>
          </li>
        </ul>
      
        <div class="navbar-nav ml-0 pr-2 pl-2 rounded" style="background-color: white;">
          <div class="nav-item dropdown">
            <a data-toggle="dropdown" class="nav-link dropdown-toggle user-action "><i class="fa fa-user" aria-hidden="true"></i>
            <?php echo $_SESSION['user']['username'] ?></a>
            <div class="dropdown-menu">
              <a href="profile.php" class="dropdown-item p-1"><i class="fa fa-id-card" aria-hidden="true"></i> Profile</a>
              <div class="dropdown-divider"></div>
              <a class="nav-link dropdown-item p-1" href="../../registration/index.php?logout='1'">
                <i class="fa fa-power-off" aria-hidden="true"></i> Log out
              </a> 
            </div>
          </div>
        </div>
        
      </div>                   
    </nav>
  </div>
  <!-- /Navigation Bar -->

  
  
    
    <div class="row justify-content-center mt-5 pt-5">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 card img-thumbnail mr-3" style="background-color: #fafafa; box-shadow: 0 20px 50px 0 rgb(78, 132, 164);">
            <div class="text-center">
                <h2 >Change Username/Password</h2>
            </div>
            <hr>
            <form method="post" action="profile.php">
                <?php include('../../registration/errors.php'); ?>

                <div class="form-group">
                    <label >Username</label>
                    <input type="username" class="form-control"  name="curUsername" id="curUsername"  placeholder=" Enter current username" >                  
                </div>
                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control" name="curPassword" id="curPassword" placeholder="Enter current password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}">
                </div>
                <div class="form-group">
                    <label >New username</label>
                    <input type="username" class="form-control" name="newUsername" id="newUsername" placeholder="Enter new username" >
                </div>
                <div class="form-group">
                    <label >New password</label>
                    <input type="password" class="form-control"  name="newPassword" id="newPassword" placeholder="Enter new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}">
                </div>
                <div class="form-group">
                    <label >Confirm password</label>
                    <input type="password" class="form-control"  name="repeatNewPassword" id="repeatNewPassword" placeholder="Confirm new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}">
                </div>
                <div class="form-group text-center py-3">
                    <button type="submit" class="btn btn-info btn-block" name="submit" >Update</button>
                </div>  
            </form>

        </div>
        


        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 card img-thumbnail" style="background-color: #fafafa; box-shadow: 0 10px 20px 0 rgb(78, 132, 164);">
            <div class="text-center">
                <h2>View Profile History </h2> 
            </div>
            <hr>
            <br>
            <div class="container">
                <?php
                  include('../../databases/connection.php');
                  $result = mysqli_query($connection_db, "SELECT * FROM UploadUserHistory WHERE user_id= $userID");
                ?>
                <?php
                  if (mysqli_num_rows($result) > 0) {
                ?>

                  <table class='table table-bordered table-striped'>
                  <tr>
                    <td>Last Uploads</td>
                    <td>Number of Records</td>
                  </tr>

                  <?php
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                  ?>
                    <tr>
                      <td><?php echo $row["upload_date"]; ?></td>
                      <td><?php echo $row["num_records"]; ?></td>
                    </tr>

                  <?php
                      $i++;
                    }
                  ?>

                  </table>
                  <?php
                  }
                  else{
                    echo "No history available!";
                  }
                ?>
            </div>
        </div>
    </div>    
   
    <!-- footer -->
    <footer class="bg-light p-1 text-center text-dark border-top fixed-bottom ">
        <p>
            &copy; Copyrights <strong>Our Team</strong>. All Rights Reserved
        </p>
    </footer>
    <!-- /footer -->

    <!-- Links to bootstrap.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- /Links to bootstrap.js -->

    
</body>

</html>