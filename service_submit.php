<?php
include("dbconnect.php");
session_start();
if(!isset($_SESSION['signin'])){
    header("location: index.php");
}

if(isset($_POST['submit_service'])) {
    $event_id = $_POST['result'];
    $services = $_POST['additional_info'];
    //$price = $_POST['service_price'];
    
    foreach($services as $service) {
        
        $service = mysqli_real_escape_string($conn, $service);
        
        
            $sql = "INSERT INTO services (event_id, service_name ) VALUES ('$event_id', '$service')";
            $execute = mysqli_query($conn, $sql);
            
           
            if($execute) {
               $_SESSION['uploaded'] = true;
               //mysqli_stmt_close($sql);
               header("location:add_services.php");
            } 
        
       
    }
}
?>
