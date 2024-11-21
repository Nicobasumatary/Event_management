<?php
include('dbconnect.php');
$email = $_GET['result'];
$query = "DELETE FROM user_regis where email = '$email'";
$data = mysqli_query($conn,$query);

if($data){
    header("location: users.php");
}
?>