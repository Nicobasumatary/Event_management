<?php
include('dbconnect.php');
$event_id = $_GET['result'];
$query_check = "SELECT * FROM events_booking WHERE event_id = '$event_id'";
$result_check = mysqli_query($conn, $query_check);

if (mysqli_num_rows($result_check) > 0) {
    $_SESSION['error'] = true;
    header("location:view_events.php");
} else {

    $query = "DELETE FROM events_list WHERE event_id = '$event_id'";
    $data = mysqli_query($conn, $query);

    if ($data) {
       // $_SESSION['deleted'] = true;
        header("location: view_events.php");
    } else {
       
        echo 'Delete operation failed.';
    }
}


mysqli_close($conn);
?>
