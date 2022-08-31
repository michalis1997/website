<?php   
    include('../../../registration/server.php');
 
    // If the user is not logged in and tries to access this page, they are automatically redirected to the login page. 
    if (!isset($_SESSION['user'])) {
      $_SESSION['msg'] = "You must log in first";
      header('Location: ../../../registration/login.php');
    }
  
    // Checks if the user has clocked the logout button. If yes, the system logs them out and redirects them back to the login page.
    if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['user']);
      header('Location: ../../../registration/login.php');
    }
    
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <title>About us</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- links to css files/libraries  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <link rel="stylesheet" href="../design.css">
    
</head>

<body style="background-color: #fafafa;">

    <!-- Navigation Bar  -->
    <div class="container">
        <nav class="navbar fixed-top navbar-expand-md navbar-light" style="background-color: rgb(35, 89, 116)" >
        
        <a href="../user_app.php"><img src="../../images/logo.png"/></a>
        
        <!-- dropdown toggler when screen size is too small -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- /dropdown toggler when screen size is too small -->

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto navbar-spacing mr-3" >
            <li class="nav-item active pr-2" >
                <a class="nav-link text-light" href="../user_app.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>

            <li class="nav-item active pl-2" >
                <a class="nav-link text-light" href="../about_us/about_us.php"><i class="fa fa-users" aria-hidden="true"></i> About</a>
            </li>

            <li class="nav-item active pl-2" >
                <a class="nav-link text-light" href="contact_us.php"><i class="fa fa-envelope" aria-hidden="true"></i> Contact</a>
            </li>
            </ul>
        

            <div class="navbar-nav ml-0 pr-2 pl-2 rounded" style="background-color: white;">
            <div class="nav-item dropdown">
                <a data-toggle="dropdown" class="nav-link dropdown-toggle user-action "><i class="fa fa-user" aria-hidden="true"></i>
                <?php echo $_SESSION['user']['username'] ?></a>
                <div class="dropdown-menu">
                <a href="../profile.php" class="dropdown-item p-1"><i class="fa fa-id-card" aria-hidden="true"></i> Profile</a>
                <div class="dropdown-divider"></div>
                <a class="nav-link dropdown-item p-1" href="../../../registration/index.php?logout='1'">
                    <i class="fa fa-power-off" aria-hidden="true"></i> Log out
                </a> 
                </div>
            </div>
            </div>
            
        </div>                   
        </nav>
    </div>
    <!-- /Navigation Bar -->

   
  <!-- header area -->
  <div class="about-section text-light mt-5" style="background-color: #5D6D7E">
    <div class="mt-5 mb-5 pt-5 pb-5 text-center"> 
      <h1>Contact Us</h1>
    </div>
  </div>
  <!-- /header area -->


    <div class="container card mb-5 pb-5 pr-0 pl-0" style="background-color: #fafafa; box-shadow: 0 20px 50px 0 rgb(78, 132, 164);">

        <div class="row mb-4">
            <div class="card-header w-100" style="background-color: rgb(35, 89, 116);">
                <div class="h4 text-center text-light mb-3">
                    Got a question? <br> We'd love to hear from you. Send us a message and we'll response as soon as possible.
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                
                <div class="ml-2 container row vertical-center-row mt-4">
                <div class="text-center col-md-4 col-md-offset-4"></div>
                <form action="mailto: up1056645@upatras.gr, up1056646@upatras.gr , up1049789@upatras.gr" method="post" enctype="text/plain">
                    
                        Name:<br>
                        <input class="mb-2" type="text" name="name" style="width: 300px"><br>
                
                        E-mail:<br>
                        <input type="text" name="mail" style="width: 300px"><br><br>
                    
                        Message:<br>
                        <input type="text" name="comment" style="height: 100px; width: 400px"><br><br>
                            
                    
                    
                    <input class="btn btn-secondary btn-block" type="submit" value="Send">
                    <input class="btn btn-secondary btn-block" type="reset" value="Reset">  
                
                </form>  
                </div>
            </div>
            <div class="col-4">
                <div class="mr-5">
                    <img src="../../images/contact_us.png" class="w-100 h-100">
                </div>
            </div>

        </div>    
     
    </div>
 





  <!-- footer -->
  <footer class="fixed-bottom bg-light p-1 text-center text-dark border-top">
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
