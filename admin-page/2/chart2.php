<?php


include('C:/wamp64/www/web/databases/connection_to_db.php');


$queryChart2 = "SELECT entries.id, entries.startedDateTime as hour, req_res_head.res_h_name, req_res_head.res_h_value, entries.timings_wait as response_time
                        FROM entries
                        INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
                        WHERE (req_h_name = 'content-type' OR res_h_name= 'content-type') AND 
                                (   (req_h_value LIKE 'application%' OR res_h_value LIKE 'application%') OR 
                                    (req_h_value LIKE 'text%' OR res_h_value LIKE 'text%')   OR
                                    (req_h_value LIKE 'html%' OR res_h_value LIKE 'html%')   OR
                                    (req_h_value LIKE 'image%' OR res_h_value LIKE 'image%') OR
                                    (req_h_value LIKE 'video%' OR res_h_value LIKE 'video%') OR
                                    (req_h_value LIKE 'font%' OR res_h_value LIKE 'font%') )
                        GROUP BY entries.startedDateTime";
//execute query
$reschart2= mysqli_query($connection_db ,$queryChart2);


$chart2a = array(); 

while($row = mysqli_fetch_assoc($resChart2)){
  array_push( $chart2a ,   [   'hour' => $row['hour'] , 'response_time' => $row['response_time'] ]);
}

echo json_encode($chart2a);



?>

<!DOCTYPE html>
<html lang="el">
<head>
  <title>Login</title>
  <!-- Setting the viewport to make your website look good on all devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  
    
</head>
<body>
  <div style="width: 400px;">
	<canvas id="Chart" height="400" width="400"> </canvas>

	</div>

	
	<script  type="text/javascript" src="C:/wamp64/www/web/website/admin-page/2/chart2.js"></script>

</body>
</html>