<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Content-Type: application/json; charset=UTF-8");

    include('../../databases/connection.php');
    
    if (isset($_GET['mapChart'])){
        $mapChart = $_GET['mapChart'];
    }

    if ($mapChart == 1){
        //select harIPAddress, latitude, longitude,  count
        $queryMap = " SELECT  UploadUserHistory.user_id as userID, 
                        entries.har_id, 
                        UploadUserHistory.userIPAddress as userIP, 
                        UploadUserHistory.latitude as userLat, 
                        UploadUserHistory.longitude as userLong, 
                        responseip.harIPAddress as responseIP, 
                        responseip.latitude as resLat, 
                        responseip.longitude as resLong, 
                        count(entries.serverIPAddress) as count 
                        FROM UploadUserHistory
                        INNER JOIN entries ON UploadUserHistory.har_id = entries.har_id
                        INNER JOIN responseip ON entries.serverIPAddress = responseip.harIPAddress
                        GROUP BY user_id, har_id, responseip.harIPAddress";



        $resData = mysqli_query($connection_db ,$queryMap);

        $admin4 = array(); 
        while($row = mysqli_fetch_assoc($resData)){

        array_push( $admin4 ,   [   'userID' => $row['userID'], 
                        'latitude' => $row["userLat"], 'longitude' => $row["userLong"] , 
                        'resLatitude' => $row['resLat'], 'resLongitude' => $row['resLong'] , 
                        'responseIP' => $row['responseIP'], 'countResIP' => $row['count']
                    ]);
        }

        echo json_encode($admin4);

    }


    

?>
