<?php
include("dbconnect.php");


    $page_id = $_GET['result'];

    $sql = "DELETE from pages where page_id = $page_id";
    $execute = mysqli_query($conn,$sql);

    if($execute){
        header("location:manage_page.php");
    }


?>