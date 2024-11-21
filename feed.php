<?php
include("dbconnect.php");
session_start();


if(isset($_POST['feed_submit'])){
    $feed = $_POST['message'];

    if(isset($_SESSION['login'])){
        $email = $_SESSION['login'];
        $sql = "SELECT * FROM user_regis where email = '$email'";
        $execute = mysqli_query($conn, $sql);
        if($execute){
            $data =  mysqli_fetch_assoc($execute);
            $user_id = $data['u_id'];
            $username = $data['username'];
        
        }
       
    }
    $sql = "INSERT INTO feedback (u_id, username, feedback) values (?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    $prepare_stmt = mysqli_stmt_prepare($stmt,$sql);
    if($prepare_stmt){
        mysqli_stmt_bind_param($stmt,'iss',$user_id,$username,$feed);
        mysqli_stmt_execute($stmt);
        $_SESSION['submitted'] = true;
        header("location:event.php");
    }
}


?>