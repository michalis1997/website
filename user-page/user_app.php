<?php
 
  include('../../registration/server.php');
 
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
  <title>HTTP Traffic Analyzer</title>
  <meta charset="utf-8">
  <!-- Setting the viewport to make your website look good on all devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Libraries CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../design.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <!-- leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js" integrity="sha512-KhIBJeCI4oTEeqOmRi2gDJ7m+JARImhUYgXWiOTIp9qqySpFUAJs09erGKem4E5IPuxxSTjavuurvBitBmwE0w==" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous"></script>

  <!-- lefalet heatmap links -->
  <script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>   
  <!-- file saver cdn link -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous"></script>
  
  <script type="text/javascript" src="//geoip-js.com/js/apis/geoip2/v2.1/geoip2.js"></script>

  <style>
    #map { width: 100%; height: 600px; }
    h1 {
      font-family: Garamond;
    }
  </style>    
    

</head>

<body>

  <!-- Navigation Bar  -->
  <div class="container">
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

  <br>

  <!-- Header section (carousel) -->
  <div id="carouselExampleIndicators" class="carousel slide carousel-fade jumbotron" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner carousel-fade">
      <div class="carousel-item active">
        <img class="d-block w-100 " src="../images/carousel2.jpg" alt="First slide">
        <div class="carousel-caption d-none d-md d-md-block">
          <h1 class="display-4">Upload you own HAR file</h1>
          <p> You can upload your har file without worrying about your personal sensitive data and we take care to analyze your har's http traffic 
            and visualize it on heatmap.
              Also you can save to a local folder without any sensitive data for future use.  
          </p>
        </div>
      </div> 
      <div class="carousel-item">
        <img class="d-block w-100" src="../images/carousel3i.jpg" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="../images/carousel2.jpg" alt="Third slide">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

  </div>
  <!-- /Header section (carousel) -->

  
 
  <!-- ---------------------------------------------- CONTENT SECTION ---------------------------------------------------------------------------------->
  <div style="background-color: #D8E4EA"> 
    <div class="pt-5 pb-3">
      <div class="container text-dark mb-5 board" style="background-color: rgb(190, 219, 229); box-shadow: 0 20px 50px 0 rgb(78, 132, 164);"> 
          <div class="row justify-content-md-center">
            <h2 class="mb-5 card-header w-100 font-weight-light text-center " style="background-color: rgb(217, 237, 243);">Start here:</h2>
            <div class="justify-content-center pl-5">
                <input class="border mb-5 mr-3 bg-info text-white" type="file" id="getHar" name="fileUpload" accept=".json, .har, .txt">
            </div>
          </div>      
      </div>

      <div class="container text-dark mb-5 board " style="background-color: rgb(190, 219, 229); box-shadow: 0 20px 50px 0 rgb(78, 132, 164);">
        <div id="showButtons" style="display:none;">  
          <div class="row justify-content-md-center">
            <h2 class="mb-5 card-header w-100 font-weight-light text-center " style="background-color: rgb(217, 237, 243);">
                You can save the process file or you can Upload on system and show on map</h2>
            <div class="container">
              <div class="row" style="margin-right: 20%; margin-left: 20%; ">  
                <button class="container mb-4 btn btn-block" id="saveFileLocally" style="background-image: linear-gradient(to top, #007dc5, #34b2b4); color: white; text-align: center;">Save As</button>
              </div>
              <div class="row" style="margin-right: 20%; margin-left: 20%; ">  
                <button class="container mb-4 btn btn-block" id="uploadFile" style="background-image: linear-gradient(to top, #007dc5, #34b2b4); color: white; text-align: center;">Upload on System</button><br/>    
              </div>
              <div class="row" style="margin-right: 20%; margin-left: 20%; ">  
                <button class="container mb-4 btn btn-block" id="ShowMap" style="background-image: linear-gradient(to top, #007dc5, #34b2b4); color: white; text-align: center;">Show on Map</button><br/>
              </div>
              <div class="row" style="margin-right: 20%; margin-left: 20%; ">  
                <button class="container mb-4 btn btn-block" id="resetHeatmap" style="background-image: linear-gradient(to top, #007dc5, #34b2b4); color: white; text-align: center;">Reset Previous Map data</button><br/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!------------ Heatmap ------------>
  <div style="background-color: #98AEB6"> 
    <div id="showHeatMap" class="mb-0 pb-5" style="display:none; width:100%"> 
      
      <div class="text-dark mb-5 board">
        <div class="row justify-content-md-center">
          <h2 class="mb-5 card-header font-weight-light mt-3" style="background-color: rgb(217, 237, 243); box-shadow: 0 20px 50px 0 rgb(78, 132, 164);">Visualize of HTTP sending requests as to crowdsourced information for HTML, PHP, ASP and JSP files</h2>
        </div>
        
        <div class="container">
          <div id="map" class="border border-white" style="box-shadow: 0 20px 50px 0 rgb(78, 132, 164);"></div> 
        </div>
        
      </div>
    </div>
  </div>
  <!------------ /Heatmap ------------>
   
  













    
  
  <!-- footer -->
  <footer class="bg-light p-1 text-center text-dark border-top">
    <p>
      &copy; Copyrights <strong>Our Team</strong>. All Rights Reserved
    </p>
  </footer>
  <!-- /footer -->


  <!-- Links to js files -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="HeatLayer.js"></script>
  <script src="leaflet-heat.js"></script>
  <script src="proccesses.js"></script>
  <!-- /Links to js files -->


</body>
</html>