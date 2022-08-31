<?php
include('C:/wamp64/www/web/databases/connection_to_db.php');
 ?>

<!DOCTYPE html>
<html>
    <head>

    <title>HTTP Traffic Analyzer</title>
        <meta charset="utf-8">
        <!-- Setting the viewport to make your website look good on all devices -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
        <link rel="stylesheet" href="ResponseTimes.css">


<!-- Navigation Bar  -->
    <div class="container mb-4">
     <nav class="navbar fixed-top navbar-expand-md navbar-light" style="background-color: rgb(35, 89, 116)" >
      <a href="http://localhost/web/website/admin-page/admin_app"><img src="../images/logo.png"/></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto navbar-spacing mr-3" >
          <li class="nav-item active pr-2" >
            <a class="nav-link text-light" href="http://localhost/web/website/admin-page/admin_app.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
          </li>
          <li class="nav-item active pl-2" >
            <a class="nav-link text-light" href="http://localhost/web/website/admin-page/about_admin/about_admin.php"><i class="fa fa-users" aria-hidden="true"></i> About</a>
          </li>
        </ul>
        <div class="navbar-nav ml-0 pr-2 pl-2 rounded" style="background-color: white;">  
        <div class="nav-item dropdown">
            <a data-toggle="dropdown" class="nav-link dropdown-toggle user-action "><i class="fa fa-user" aria-hidden="true"></i>
            <?php echo $_SESSION['user']['username'] ?></a>
            <div class="row justify-content-md-center">
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
    </head>
    <body>
    
    <div class="container">  
        <h3 align="center">Use the dropdown list below to select the table you want to see</h3>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choose from the list below
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="3.php?dropdown=1"> TTL per Content Type </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="3.php?dropdown=2"> Max-Stale and Min-Stale (%) directives </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="3.php?dropdown=3">Cacheability Directives (%)</a>
          </div>
        </div>
        <br />
        <div class="table-responsive">
            <table id="data" class="table table-striped table-bordered text-center">
         <?php
            if (isset($_GET['dropdown'])){
              $dropdown = $_GET['dropdown'];
            } else {
              $dropdown = 0;
            }

            if ($dropdown == 1){
                echo '
                            <thead>  
                                <tr>
                                    <td>ISP</td>
                                    <td>Content Type</td>  
                                    <td>Max Age</td>
                                </tr>  
                            </thead> 
                ';

                $query = "SELECT ISP, A.res_h_value AS content_type, B.res_h_value AS max_age FROM req_res_head AS A
                INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
                INNER JOIN entries ON A.entry_id = entries.id
                INNER JOIN UploadUserHistory ON entries.har_id = UploadUserHistory.har_id
                WHERE (A.res_h_name = 'content-type') AND (B.res_h_name = 'cache-control') AND (B.res_h_value LIKE '%max-age%')
                GROUP BY A.res_h_value, ISP;";
                $result = mysqli_query($connection_db, $query);

                while($row = mysqli_fetch_array($result))  
                {  
                    echo '  
                                <tr>
                                    <td>'.$row["ISP"].'</td> 
                                    <td>'.$row["content_type"].'</td>
                                    <td>'.$row["max_age"].'</td>
                                </tr>
                            
                    ';  
                }
            } else if ($dropdown == 2) {
                echo '
                            <thead>  
                                <tr>
                                    <td>ISP</td>  
                                    <td>Content Type</td>
                                    <td>Cache Control</td>  
                                    <td>Percentage</td>  
                                </tr>  
                            </thead> 
                ';

                $query = "SELECT COUNT(*) AS total FROM req_res_head
                INNER JOIN entries ON req_res_head.entry_id = entries.id
                INNER JOIN UploadUserHistory ON entries.har_id = UploadUserHistory.har_id
                WHERE res_h_name = 'cache-control' AND ((res_h_value LIKE '%min-fresh%') OR (res_h_value LIKE '%max-stale%'));";

                $result = mysqli_query($connection_db, $query);

                while ($row = mysqli_fetch_array($result)){
                    $count = $row['total'];
                }

                $query = "SELECT ISP, res_h_name AS content_type, res_h_value AS cache_control, COUNT(*) AS percentage FROM req_res_head
                INNER JOIN entries ON req_res_head.entry_id = entries.id
                INNER JOIN UploadUserHistory ON entries.har_id = UploadUserHistory.har_id
                WHERE res_h_name = 'cache-control' AND ((res_h_value LIKE '%min-fresh%') OR (res_h_value LIKE '%max-stale%'))
                GROUP BY res_h_value, ISP;";
                $result = mysqli_query($connection_db, $query);

                while($row = mysqli_fetch_array($result))  
                {  
                    echo '  
                                <tr>
                                    <td>'.$row["ISP"].'</td> 
                                    <td>'.$row["content_type"].'</td>
                                    <td>'.$row["cache_control"].'</td>
                                    <td>'.bcdiv(($row["percentage"]*100) / $count, 1, 3).'</td> 
                                </tr>
                            
                    ';  
                } 

            } else if ($dropdown == 3){
                echo '
                            <thead>  
                                <tr>
                                    <td>ISP</td>  
                                    <td>Content Type</td>
                                    <td>Cacheability Directive</td>  
                                    <td>Percentage</td>  
                                </tr>  
                            </thead> 
                ';

                $query = "SELECT COUNT(*) AS total FROM req_res_head
                INNER JOIN entries ON req_res_head.entry_id = entries.id
                INNER JOIN UploadUserHistory ON entries.har_id = UploadUserHistory.har_id
                WHERE ((res_h_value like '%public%') OR (res_h_value like '%private%') OR (res_h_value like '%no-cache%') OR (res_h_value like '%no-store%'));";

                $result = mysqli_query($connection_db, $query);

                while ($row = mysqli_fetch_array($result)){
                    $count = $row['total'];
                }

                $query = "SELECT ISP, res_h_name AS content_type, res_h_value AS cacheability_directive, COUNT(res_h_value) AS percentage FROM req_res_head
                INNER JOIN entries ON entry_id = entries.id
                INNER JOIN UploadUserHistory ON entries.har_id = UploadUserHistory.har_id
                WHERE ((res_h_value LIKE '%public%') OR (res_h_value LIKE '%private%') OR (res_h_value LIKE '%no-cache%') OR (res_h_value like '%no-store%'))
                GROUP BY res_h_value, ISP;";
                $result = mysqli_query($connection_db, $query);

                while($row = mysqli_fetch_array($result))  
                {  
                    echo '  
                                <tr>
                                    <td>'.$row["ISP"].'</td> 
                                    <td>'.$row["content_type"].'</td>
                                    <td>'.$row["cacheability_directive"].'</td>
                                    <td>'.bcdiv(($row["percentage"]*100), $count, 3).'</td> 
                                </tr>
                    ';  
                }
            }
          ?>
          </table>
        </div>
  </body>
</html>