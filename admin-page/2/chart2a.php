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
      <a href="admin_app.php"><img src="../images/logo.png"/></a>
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

      <div class="row justify-content-md-center">
          <h2 class="mb-5 card-header w-100 font-weight-light text-center " style="background-color: rgb(217, 237, 243);">
                Analyze Response Times to Requests per hour of the day</h2>
                <div class="col-md-4 col-sm-4 col-xs-4 justify-content-center" >
                    <form class="" action="http://localhost/web/website/admin-page/2/chart2b.php" method="post">
                    <button class="container mb-4 btn" name="button2" id="chart2b" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">Days of the Week </button>
                    </form>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4 justify-content-center" >
                    <form class="" action="http://localhost/web/website/admin-page/2/chart2c.php" method="post">
                    <button class="container mb-4 btn" name="button3" id="chart2c" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">Http Request Method</button>
                    </form>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4 justify-content-center" >
                    <form class="" action="http://localhost/web/website/admin-page/2/chart2d.php" method="post">
                    <button class="container mb-4 btn"  name="button4" id="chart2d" style="background-color: rgb(35, 89, 116); color: white; text-align: center;">ISP Provider Connectivity</button>
                    </form>
                </div>

        </div>

    </head>
    <body>
    <?php

    
     $data = array('text'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
     'application'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
     'image'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
     'font'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
     'video'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 
     'audio'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]);


        $queryChart2 = "SELECT ROUND(SUM(timings_wait), 2) AS total, SUBSTRING_INDEX(res_h_value, '/', 1) AS content_type, HOUR(DATE_FORMAT(startedDateTime,'%Y-%c-%d %T')) AS h FROM entries
        INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
        WHERE res_h_name = 'content-type'
        GROUP BY content_type, h;";

        //execute query
        $reschart2= mysqli_query($connection_db ,$queryChart2);

    
        while($row = mysqli_fetch_array($reschart2)){
        $data[$row['content_type']][$row['h'] - 1] = $row['total'];
        }

        $text = array_values($data['text']);
        $text = json_encode($text);

        $application = array_values($data['application']);
        $application = json_encode($application);

        $image = array_values($data['image']);
        $image = json_encode($image);

        $font = array_values($data['font']);
        $font = json_encode($font);

        $video = array_values($data['video']);
        $video = json_encode($video);

        $audio = array_values($data['audio']);
        $audio = json_encode($audio);


        echo '
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                var ctx = $("#chart-line");
                var myLineChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
                        datasets: [{
                            data: '.$text.',
                            label: "text",
                            borderColor: "#458af7",
                            backgroundColor: "#458af7",
                            fill: false
                        }, {
                            data: '.$application.',
                            label: "application",
                            borderColor: "#8e5ea2",
                            backgroundColor: "#8e5ea2",
                            fill: false
                        }, {
                            data: '.$image.',
                            label: "image",
                            borderColor: "#3cba9f",
                            backgroundColor: "#3cba9f",
                            fill: false
                        }, {
                            data: '.$font.',
                            label: "font",
                            borderColor: "#FF5733",
                            backgroundColor: "#FF5733",
                            fill: false
                        }, {
                            data: '.$video.',
                            label: "video",
                            borderColor: "#581845",
                            backgroundColor: "#581845",
                            fill: false
                        }, {
                            data: '.$audio.',
                            label: "audio",
                            borderColor: "#17202A",
                            backgroundColor: "#17202A",
                            fill: false
                        }
                        ]
                    },
                    options: {
                        title: {
                            display: false
                        }
                    }
                });
            });
        </script>
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row">
                    <div class="container-fluid d-flex justify-content-center">
                        <div class="col-sm-8 col-md-6">
                            <div class="card">
                                <div class="card-header">Mean Response Time per Hour of Day per Type of Web-Object</div>
                                <div class="card-body" style="height: 420px">
                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                        </div>
                                    </div> <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
    
    ?>
     
  </body>
</html>