<?php
include('dbconnect.php');


    $booking_id = $_GET['result'];

    $sql = "update events_booking set status = 'approved' where booking_id = $booking_id";
    $execute = mysqli_query($conn,$sql);
    if($execute){
       // $_SESSION['approved'] = true;
       header('location:admin_booking_list.php');

    }



?>