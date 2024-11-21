<?php
include ("dbconnect.php");
session_start();
require_once("fpdf/fpdf.php");

if (isset($_POST['book'])) {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $descript = $_POST['description'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $services = $_POST['service'];
    //$services_string = 'NULL';
   
    foreach ($services as $service) {
        $services_string .= $service . ', ';
    }

    if (!empty($services)) {
        $services_string = implode(', ', $services);
    } else {
        $services_string = "Others";
    }
    if(empty($descript)){
        $descript = " ";
    }
    // Validate date format and range
     if (strtotime($fromdate) >= strtotime($todate)) {
         $_SESSION['booking_error'] = "Invalid date range. Please select valid dates.";
         header("Location: event.php");
         exit;
     }

    // Retrieve user details from session
    if (isset($_SESSION['login'])) {
        $email = $_SESSION['login'];
        $query = "SELECT * FROM user_regis WHERE email = '$email'";
        $execute = mysqli_query($conn, $query);
        if ($execute) {
            $data = mysqli_fetch_assoc($execute);
            $userid = $data['u_id'];
            $user_email = $data['email'];
            $username = $data['username'];
            $phone = $data['phnno'];
            $status = "pending";
        }
    }

    $services_string = rtrim($services_string, ', ');


    $sql = "INSERT INTO events_booking (event_id,event_name, u_id, username, email, phnno, services_selected, description, from_date, to_date, status) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "isississsss", $event_id,$event_name, $userid, $username, $user_email, $phone, $services_string, $descript, $fromdate, $todate, $status);


        if (mysqli_stmt_execute($stmt)) {
            //$booking_id = mysqli_insert_id( $conn);
            $_SESSION['booking_success'] = true;
            header("Location:user_profile.php");
            exit;
        } else {
            // Error
            $_SESSION['booking_error'] = "Error inserting event booking. Please try again.";
            header("Location: event.php");
            exit;
        }
    } else {
        // Error preparing statement
        $_SESSION['booking_error'] = "Error preparing SQL statement. Please try again.";
        header("Location: event.php");
        exit;
    }


}
?>