<?php
session_start();
include("dbconnect.php");

$booking_id = $_GET['booking_id'];
$sql = "select * from events_booking where booking_id = $booking_id";
$execute = mysqli_query($conn, $sql);
if(mysqli_num_rows($execute) > 0) {
    $row = mysqli_fetch_array($execute);
    $event_id = $row['event_id'];
    $event_name = $row['event_name'];
    $user_id = $row['u_id'];
    $username = $row['username'];
    $email = $row['email'];
    $phone = $row['phnno'];
    $services = $row['services_selected'];
    $description = $row['description'];
    $fromdate = $row['from_date'];
    $todate = $row['to_date'];
    //$status = $row['status'];
}
// if(isset($_SESSION["booking_success"])){
// $booking_id = $_SESSION["booking_success"];
// $query = "select * from events_booking where booking_id = $booking_id";
// $result = mysqli_query($conn, $query);
// if($result){
//     $row = mysqli_fetch_array($result);
//     $event_id = $row['event_id'];
//     $user_id = $row['u_id'];
//     $username = $row['username'];
//     $email = $row['email'];
//     $phone = $row['phnno'];
//     $services = $row['services_selected'];
//     $description = $row['description'];
//     $fromdate = $row['from_date'];
//     $todate = $row['to_date'];
//     //$status = $row['status'];
// }  

//}
?>

<?php
require_once("fpdf/fpdf.php");

// Create a class that extends FPDF and includes a custom footer method
class PDF extends FPDF
{
    // Custom footer method
    function Footer()
    {
        // Set the Y position to 15 mm from the bottom of the page
        $this->SetY(-15);

        // Set the font style and size
        $this->SetFont('Arial', 'I', 10);

        // Add the footer text centered on the page
        $this->Cell(0, 10, 'This form is to be shown to the executives during meeting', 0, 0, 'C');
    }
}

// Create an instance of the PDF class
$pdf = new PDF('P', 'mm', 'A4');

// Add a new page
$pdf->AddPage();

// Set the page border width and style
$borderWidth = 0.5; // Thickness of the border in mm
$pdf->SetLineWidth($borderWidth);

// Set the draw color for the border (black)
$pdf->SetDrawColor(0, 0, 0);

// Get the page width and height
$width = $pdf->GetPageWidth();
$height = $pdf->GetPageHeight();

// Draw a border around the page
$pdf->Rect(5, 5, $width - 10, $height - 10, 'D'); // 'D' for drawing border

// Add the title
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(0, 10, "WePlan", 0, 1, 'C'); // Centered title
$pdf->Cell(0, 10, "Booking Details", 0, 1, 'C'); // Centered subheading

// Reset the font for booking details
$pdf->SetFont("Arial", "", 10);

// Add booking details as a form-like structure
// Label-value pairs for booking details
$pdf->Cell(30, 10, "Username:", 0, 0, 'L');
$pdf->Cell(70, 10, "$username", 0, 1, 'L');
$pdf->Cell(30, 10, "Email:", 0, 0, 'L');
$pdf->Cell(70, 10, "$email", 0, 1, 'L');
$pdf->Cell(30, 10, "Phone:", 0, 0, 'L');
$pdf->Cell(70, 10, "$phone", 0, 1, 'L');
$pdf->Cell(30, 10, "Booking ID:", 0, 0, 'L');
$pdf->Cell(70, 10, "$booking_id", 0, 1, 'L');
$pdf->Cell(30, 10, "Event ID:", 0, 0, 'L');
$pdf->Cell(70, 10, "$event_id", 0, 1, 'L');
$pdf->Cell(30, 10, "Event:", 0, 0, 'L');
$pdf->Cell(70, 10, "$event_name", 0, 1, 'L');
$pdf->Cell(30, 10, "From Date:", 0, 0, 'L');
$pdf->Cell(70, 10, "$fromdate", 0, 1, 'L');
$pdf->Cell(30, 10, "To Date:", 0, 0, 'L');
$pdf->Cell(70, 10, " $todate", 0, 1, 'L');
$pdf->Cell(30, 10, "Services:", 0, 0, 'L');
$pdf->Cell(70, 10, "$services", 0, 1, 'L');
$pdf->Cell(30, 10, "Others:", 0, 0, 'L');
$pdf->Cell(70, 10, "$description", 0, 1, 'L');
//$pdf->Cell(30, 10, "Status:", 0, 0, 'L');
//$pdf->Cell(70, 10, "$status", 0, 1, 'L');

// Output the PDF document
$pdf->Output('D', 'WePlan.pdf');

//header('location: user_profile.php');
?>
