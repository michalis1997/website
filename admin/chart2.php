<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Content-Type: application/json; charset=UTF-8");

    include('../../databases/connection_to_db.php');
    
    if (isset($_GET['chart2a'])){
        $chart2a = $_GET['chart2a'];
    }

    if ($chart2a == 1){
        //select harIPAddress, latitude, longitude,  count
        $queryChart2 = "SELECT entries.id, entries.startedDateTime, req_res_head.res_h_name, req_res_head.res_h_value, entries.timings_wait 
                        FROM entries
                        INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
                        WHERE (req_h_name = 'content-type' OR res_h_name= 'content-type') AND 
                                (   (req_h_value LIKE 'application%' OR res_h_value LIKE 'application%') OR 
                                    (req_h_value LIKE 'text%' OR res_h_value LIKE 'text%')   OR
                                    (req_h_value LIKE 'html%' OR res_h_value LIKE 'html%')   OR
                                    (req_h_value LIKE 'image%' OR res_h_value LIKE 'image%') OR
                                    (req_h_value LIKE 'audio%' OR res_h_value LIKE 'audio%') OR
                                    (req_h_value LIKE 'video%' OR res_h_value LIKE 'video%') OR
                                    (req_h_value LIKE 'font%' OR res_h_value LIKE 'font%') )
                        GROUP BY entries.startedDateTime";



        $resChart2 = mysqli_query($connection_db ,$queryChart2);

        $chart2a = array(); 
        while($row = mysqli_fetch_assoc($resChart2)){

        array_push( $chart2a ,   [   'startedDateTime' => $row['startedDateTime'] ]);
        }

        echo json_encode($chart2a);
        exit;

    }
 

?>
