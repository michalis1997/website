<?php 
    header('Access-Controll-Allow-Origin: *');
    include('../../databases/connection_to_db.php');
   
    // Read $_GET value
    if (isset($_GET['request'])){
        $request = $_GET['request'];
    }

    $userID = $_SESSION['user']['id'];
/* --------------------------------------------------------------------------------------------------------------------------------------------------------------- */
   
    if($request == 1){
        //INSERT TO UPLOADUSERHISTORY
        $serverIPAddress = $_POST['serverIPAddress'];
        $ISPname = $_POST['Isp_name'];
        $latitude = $_POST['Latitude'];
        $longitude = $_POST['Longitude']; 
        $uploadDate = $_POST['uploadDateTime'];
        $numRecordsUpload = $_POST['numberOfRecords'];

        $insertIntoUploadUserHistory = "INSERT INTO UploadUserHistory (user_id, har_id, upload_date, num_records, userIPAddress, ISP, latitude, longitude)
        VALUES($userID, null, '$uploadDate', $numRecordsUpload, '$serverIPAddress', '$ISPname', $latitude , $longitude )";

        if(mysqli_query($connection_db, $insertIntoUploadUserHistory)){
            echo "statusCode 200";
        }else{
            echo "statusCode 201";
        }

        mysqli_close($connection_db);
        exit;  

    }    

/* --------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    if($request == 2){

        
        $sql = "SELECT COUNT(*) as count FROM UploadUserHistory WHERE user_id = '$userID' ";
        $result = mysqli_query($connection_db, $sql);
        $row = mysqli_fetch_array($result);
        $har_id = $row['count'] + 1;

        $count = 0;
        //INSERT ENTRIES
        foreach ($_POST['proccessDataReq2'] as $obj) {
            $sdt = $obj['entries']['startedDateTime'];
            $sia = $obj['entries']['serverIPAddress'];
            $tw  = $obj['entries']['timings']['wait'];
             
            $sql = "INSERT INTO entries VALUES (null, $har_id, '$sdt', '$sia', $tw)";
            $insertEntries = mysqli_query($connection_db, $sql);
                
            $count++;
            $queryEntries = "SELECT * FROM entries WHERE id = $count ";
            $results= mysqli_query($connection_db, $queryEntries);
            $row = mysqli_fetch_array($results);
            $entry_id = $row['id'];
        
            //INSERT REQ, RES , HEAD
            $req_method = $obj['request']['method'];
            $req_url = $obj['request']['url'];
            if (!empty($obj['request']['headers'])){
                foreach ($obj['request']['headers'] as $item){

                    $req_h_name = $item['name'];
                    $req_h_value = $item['value'];

                    $sql1 = "INSERT INTO req_res_head VALUES (null, $entry_id, '$req_method', '$req_url', '$req_h_name', '$req_h_value', null, null, null, null)";
                    mysqli_query($connection_db, $sql1);
                }            
            }else {
                $sql1 = "INSERT INTO req_res_head VALUES (null, $entry_id, '$req_method', '$req_url', null, null, null, null, null, null)";
                mysqli_query($connection_db, $sql1);
            }

            $resStatus = $obj['response']['status'];
            $resStatusText = $obj['response']['statusText'];
            if (!empty($obj['response']['headers'])){
                foreach ($obj['response']['headers'] as $item1){
                    
                    $res_h_name = $item1['name'];
                    $res_h_value = $item1['value'];

                    $sql2 = "INSERT INTO req_res_head VALUES (null, $entry_id, null, null, null, null, '$resStatus', '$resStatusText', '$res_h_name', '$res_h_value')";
                    mysqli_query($connection_db, $sql2);
                }            
            }else {
                $sql2 = "INSERT INTO req_res_head VALUES (null, $entry_id, null, null, null, null, '$resStatus', '$resStatusText', null, null)";
                    mysqli_query($connection_db, $sql2);
            }

        }     
        exit;

    }

/* --------------------------------------------------------------------------------------------------------------------------------------------------------------- */


    if($request == 3){

        foreach ($_POST['dataServer'] as $object) {
            $serverIPaddresss = $object['serverIPaddresss'];
            $latitude = $object['latitude'];
            $longitude = $object['longitude'];

            $query3 = "INSERT INTO responseip  VALUES(null, '$serverIPaddresss', $latitude , $longitude )";
            mysqli_query($connection_db, $query3);
        }

        exit;

    }


/* --------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    // Fetch records (from db)
    if($request == 4){
        
        //select harIPAddress, latitude, longitude,  count
        $query4 = " SELECT responseip.harIPAddress , responseip.latitude, responseip.longitude, count(entries.serverIPAddress) AS count FROM UploadUserHistory
                    INNER JOIN entries ON UploadUserHistory.har_id = entries.har_id
                    INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
                    INNER JOIN responseip ON entries.serverIPAddress = responseip.harIPAddress
                    WHERE UploadUserHistory.user_id = $userID AND (req_res_head.res_h_value LIKE '%html%' 
                                                                        OR req_res_head.res_h_value LIKE '%php%'
                                                                        OR req_res_head.res_h_value LIKE '%asp%' 
                                                                        OR req_res_head.res_h_value LIKE '%jsp%'
                                                                        OR req_res_head.res_h_value LIKE '%xml%'
                                                                        OR req_res_head.res_h_value LIKE '%text%'
                                                                        OR req_res_head.res_h_value LIKE '%json%'
                                                                        OR req_res_head.res_h_value LIKE '%application%')
                    GROUP BY entries.serverIPAddress;";

        $userData = mysqli_query($connection_db, $query4);

        $userInfo = array(); 
        while($row = mysqli_fetch_array($userData)){
            array_push( $userInfo , ['latitude' => $row["latitude"], 'longitude' => $row["longitude"] , 'count' => $row["count"] ] );
        }

        echo json_encode($userInfo);
        mysqli_close($connection_db);
        exit;
        
    } 
    
/* --------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    if($request == 5){

        $query5 = "DELETE responseip FROM responseip 
                        INNER JOIN entries ON responseIP.harIPAddress = entries.serverIPAddress
                        INNER JOIN UploadUserHistory ON entries.har_id = UploadUserHistory.har_id
                        INNER JOIN registration ON UploadUserHistory.user_id = registration.id
                        WHERE registration.id= $userID ;";
                        
        mysqli_query($connection_db, $query5);

        mysqli_close($connection_db);
        exit;

    }
        

?>
