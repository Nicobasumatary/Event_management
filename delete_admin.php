<?php
include('dbconnect.php');
$email = $_GET['result'];
$query = "DELETE FROM admin where email = '$email'";
$data = mysqli_query($conn,$query);

if($data){
    header("location: add_admin.php");
}
?>