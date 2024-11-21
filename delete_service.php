<?php
include('dbconnect.php');
$service_id = $_GET['result'];
$query = "DELETE FROM services where service_id = '$service_id'";
$data = mysqli_query($conn,$query);

if($data){
    header("location: view_services.php");
}
?>