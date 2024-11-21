<?php
include("dbconnect.php");
function getPendingBookings($conn) {
    $sql = "SELECT * FROM events_booking WHERE status = 'pending'";
    $execute = mysqli_query($conn, $sql);

    // Check if query was successful
    if (!$execute) {
        die("Error executing query: " . mysqli_error($conn));
    }

    // Initialize an empty array to store bookings
    $bookings = [];

    // Fetch data into an array
    while ($row = mysqli_fetch_assoc($execute)) {
        // Add each row (booking) to the $bookings array
        $bookings[] = $row;
    }

    // Free result set
    mysqli_free_result($execute);

    return $bookings;
}



?>
