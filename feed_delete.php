<?php
include("dbconnect.php");

$feed_id = $_GET['result'];
$sql = "DELETE FROM feedback where feed_id = '$feed_id'";
$execute = mysqli_query($conn, $sql);
if($execute){
    header("location:view_feedback.php");
}

?>