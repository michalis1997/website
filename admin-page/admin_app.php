<?php
 
  include('../../registration/server.php');
 
  $userID = $_SESSION['user']['id'];

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
  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous"></script>
  <!-- chartjs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false" ></script> -->

</head>

<body style="background-color: #D8E4EA">

  <!-- Navigation Bar  -->
  <div class="container mb-4">
    <nav class="navbar fixed-top navbar-expand-md navbar-light" style="background-color: rgb(35, 89, 116)" >
      <a href="admin_app.php"><img src="../images/logo.png"/></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto navbar-spacing mr-3" >
          <li class="nav-item active pr-2" >
            <a class="nav-link text-light" href="admin_app.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
          </li>
          <li class="nav-item active pl-2" >
            <a class="nav-link text-light" href="about_admin/about_admin.php"><i class="fa fa-users" aria-hidden="true"></i> About</a>
          </li>
        </ul>
        <div class="navbar-nav ml-0 pr-2 pl-2 rounded" style="background-color: white;">
          <div class="nav-item dropdown">
            <a data-toggle="dropdown" class="nav-link dropdown-toggle user-action "><i class="fa fa-user" aria-hidden="true"></i>
            <?php echo $_SESSION['user']['username'] ?></a>
            <div class="dropdown-menu">
              <a href="profile_admin/profile_admin.php" class="dropdown-item p-1"><i class="fa fa-id-card" aria-hidden="true"></i> Profile</a>
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

  <!-- ---------------------------------------------- CONTENT SECTION ---------------------------------------------------------------------------------->
  
    <div class="pt-5 pb-3">

     <div class="text-dark mb-5 board ml-3 mr-3" style="background-color: rgb(190, 219, 229); box-shadow: 0 20px 50px 0 rgb(78, 132, 164);"> 
        <div class="justify-content-md-center">
          <h2 class="mb-5 card-header w-100 font-weight-light text-center " style="background-color: rgb(217, 237, 243);"><i class="fa fa-info-circle" aria-hidden="true"></i> ALL IN ONE INFORMATION</h2>
          <div class="ml-3 mr-3 row justify-content-md-center">
              <div class="col-md-3 col-sm-3 col-xs-3" >
                  <button class="container mb-4 btn" onclick="showChart1()" id="chart1" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">Basic Information</button>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-3">
                  <button class="container mb-4 btn" onclick="showChart2()"  id="chart2" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">Response Time to Request</button>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-3 " >
             <form class="" action="http://localhost/web/website/admin-page/3/3.php" method="post">
              <button class="container mb-4 btn"  id="chart3a" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">HTTP Headers - cache-control</button>
             </form>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-3">
                  <button class="container mb-4 btn" onclick="showChart4()" id="chart4" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">Request Data Map Visualization</button>
              </div>
          </div>
      </div>      
    </div>

    <div id="showChart1" class="container text-dark mb-5 board " style=" width:100%; background-color: white; box-shadow: 0 20px 50px 0 rgb(78, 132, 164);">
      <div class="row justify-content-md-center">
        <h2 class="mb-3 card-header w-100 font-weight-light text-center " style="background-color: rgb(217, 237, 243);">
            Basic Information</h2>
        
        <div class="container row">
          <div class="col-md-4">
                <?php
                  include('../../databases/connection.php');
                  $query = "SELECT count(id) AS num_of_registrations FROM registration";
                  $result = mysqli_query($connection_db, $query);
                ?>
                <?php
                  if (mysqli_num_rows($result) > 0) {
                ?>
                  
                  <table class='table table-bordered table-striped table-hover'>
                  <tr>
                    <td class="text-center">Total Registered Users</td>
                  </tr>

                  <?php
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                  ?>
                    <tr>
                      <td><?php echo $row["num_of_registrations"]; ?></td>
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
          <div class="col-md-4">
              <?php
                include('../../databases/connection.php');
                $query = "SELECT COUNT(DISTINCT req_url) AS num_of_dist_domains FROM req_res_head;";
                $result = mysqli_query($connection_db, $query);
              ?>
              <?php
                if (mysqli_num_rows($result) > 0) {
              ?>

              <table class='table table-bordered table-striped table-hover'>
                <tr>
                  <td class="text-center">Number of distinct Domains</td>
                </tr>

                <?php
                  $i=0;
                  while($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row["num_of_dist_domains"]; ?></td>
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
          <div class="col-md-4">
              <?php
                include('../../databases/connection.php');
                $query = "SELECT COUNT(DISTINCT userIPAddress) AS num_of_dist_isp_domains FROM UploadUserHistory;";
                $result = mysqli_query($connection_db, $query);
              ?>
              <?php
                if (mysqli_num_rows($result) > 0) {
              ?>

              <table class='table table-bordered table-striped table-hover'>
                <tr>
                  <td class="text-center">Number of distinct ISP</td>
                </tr>

                <?php
                  $i=0;
                  while($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row["num_of_dist_isp_domains"]; ?></td>
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

        
        <div class="container row">
          <div class="col-md-4">
              <?php
                include('../../databases/connection.php');
                $query = "SELECT res_status AS response_code, count(res_status) AS num_of_rec_per_status 
                          FROM req_res_head 
                          GROUP BY res_status 
                          HAVING count(res_status) > 0 AND (response_code) > 0
                          ORDER BY res_status ASC";
                $result = mysqli_query($connection_db, $query);
              ?>
              <?php
                if (mysqli_num_rows($result) > 0) {
              ?>

              <table class='table table-bordered table-striped table-hover'>
                <tr>
                  <td class="text-center" colspan="2">Records based on Response Status code</td>
                </tr>
                <tr>
                  <td class="text-center">Status Code</td>
                  <td class="text-center">Number of Records</td>
                </tr>

                <?php
                  $i=0;
                  while($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row["response_code"]; ?></td>
                    <td><?php echo $row["num_of_rec_per_status"]; ?></td>
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
                      
          <div class="col-md-4">
            <?php
              include('../../databases/connection.php');
              $query = "SELECT req_method AS method_type, count(req_method) AS num_of_rec_per_method 
                        FROM req_res_head 
                        GROUP BY req_method 
                        HAVING count(req_method) > 0;";
              $result = mysqli_query($connection_db, $query);
            ?>
            <?php
              if (mysqli_num_rows($result) > 0) {
            ?>

            <table class='table table-bordered table-striped table-hover'>
              <tr>
                <td class="text-center" colspan="2">Records based on Request Method</td>
              </tr>
              <tr>
                <td class="text-center">Method</td>
                <td class="text-center">Number of Records</td>
              </tr>

              <?php
                $i=0;
                while($row = mysqli_fetch_array($result)) {
              ?>
                <tr>
                  <td><?php echo $row["method_type"]; ?></td>
                  <td><?php echo $row["num_of_rec_per_method"]; ?></td>
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
        

          <div class="col-md-4">
              <?php
                include('../../databases/connection.php');
                $query = "SELECT A.res_h_value AS content_type_res, A.res_h_name, B.res_h_name, B.res_h_value, ROUND(AVG(B.res_h_value)) AS average_age_per_ct
                          FROM req_res_head AS A
                          INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
                          WHERE (A.req_h_name = 'content-type' AND B.req_h_name='age') OR (A.res_h_name = 'content-type' AND B.res_h_name='age')
                          GROUP BY A.res_h_value
                          ORDER BY average_age_per_ct DESC";
                $result = mysqli_query($connection_db, $query);
              ?>
              <?php
                if (mysqli_num_rows($result) > 0) {
              ?>

              <table class='table table-bordered table-striped table-hover'>
                <tr>
                  <td class="text-center" colspan="2">Average Age of each object per Content Type </td>
                </tr>
                <tr>
                  <td class="text-center">Content Type</td>
                  <td class="text-center">Average Age</td>
                </tr>

                <?php
                  $i=0;
                  while($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row["content_type_res"]; ?></td>
                    <td><?php echo $row["average_age_per_ct"]; ?></td>
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
    </div>


    <div id="showChart2" class="container text-dark mb-5 board "style="display:none; width:100%; background-color: white; box-shadow: 0 20px 50px 0 rgb(78, 132, 164);">
      <div class="row justify-content-md-center">
          <h2 class="mb-5 card-header w-100 font-weight-light text-center " style="background-color: rgb(217, 237, 243);">
                Analyze Response Times to Requests per hour of the day</h2>

        <div class="col-md-3 col-sm-3 col-xs-3 justify-content-center" >
          <form class="" action="http://localhost/web/website/admin-page/2/chart2a.php" method="post">
           <button class="container mb-4 btn" name="button1" id="chart2a" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">HTTP Object per Content Type</button>
          </form>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-3 justify-content-center" >
            <form class="" action="http://localhost/web/website/admin-page/2/chart2b.php" method="post">
            <button class="container mb-4 btn" name="button2" id="chart2b" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">Days of the Week </button>
            </form>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-3 justify-content-center" >
            <form class="" action="http://localhost/web/website/admin-page/2/chart2c.php" method="post">
            <button class="container mb-4 btn" name="button3" id="chart2c" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">Http Request Method</button>
            </form>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-3 justify-content-center" >
            <form class="" action="http://localhost/web/website/admin-page/2/chart2d.php" method="post">
            <button class="container mb-4 btn"  name="button4" id="chart2d" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">ISP Provider Connectivity</button>
            </form>
          </div>

        </div>
     </div>
    </div>



    <div id="showChart4" class="container text-dark mb-5 board" style="display:none; width:100%; background-color: white; box-shadow: 0 20px 50px 0 rgb(78, 132, 164);">
        <div class="row justify-content-md-center">
          <h2 class="mb-3 card-header w-100 font-weight-light text-center " style="background-color: rgb(217, 237, 243);">
                  Request's Data Map Visualization</h2>
          <div  class="container mb-3" >

            <h3 id="wait" class="text-center font-weight-light text-center">
              Please wait, this may take a few minutes to load
            </h3>

              <div id="map" style="height:600px; width:100%"></div>
    
          </div>

        </div>
    </div>


  </div>
    
  
  <!-- footer -->
  <footer class="bg-light p-1 text-center text-dark border-top fixed-bottom">
    <p>
      &copy; Copyrights <strong>Our Team</strong>. All Rights Reserved
    </p>
  </footer>
  <!-- /footer -->


  <!-- Links to js files -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="show_hide.js"></script>
  <script src="mapChart.js"></script>
  <!-- /Links to js files -->


</body>
</html>