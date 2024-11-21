<?php
include('dbconnect.php');
$gallery_id = $_GET['result'];
$query = "DELETE FROM gallery where gallery_id = '$gallery_id'";
$data = mysqli_query($conn,$query);

if($data){
    $_SESSION['deleted'] = true;
    header("location: manage_gallery.php");
}
?>