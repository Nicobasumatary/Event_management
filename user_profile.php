<?php
session_start();
include("dbconnect.php");

if(isset($_SESSION['login'])){
  $email = $_SESSION['login'];
  $sql = "select * from user_regis where email = '$email'";
  $execute = mysqli_query($conn, $sql);
  if($execute){
    $row = mysqli_fetch_array($execute);
    $name = $row['username'];
    $email = $row['email'];
    $phone = $row['phnno'];
   
  }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile with Booking Report</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Font (e.g., Google Fonts) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
   rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
   <link href="style.css" rel="stylesheet">
   <script>
        function redirectToFooter() {
            // Scroll to the footer
            document.getElementById('footer').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <style>
        /* Custom styles */
        html, body {
            height: 100%; /* Ensure the height is 100% */
            margin: 0; /* Remove default margin */
            font-family: 'Roboto', sans-serif; /* Apply custom font */
        }

        .full-height {
            height: 100vh; /* Full viewport height */
        }

        /* Add padding-top to the profile card and booking report card */
        .profile-card, .booking-report-card {
            padding-top: 90px; /* Customize padding-top as needed */
            border: none;
        }

        .profile-card {
            height: 100%; /* Full height for the profile card */
            overflow-y: auto; /* Enable scrolling if content overflows */
            background-image:linear-gradient(rgba(0,0,0,0.05),rgba(0,0,0,0)), url("Shape-PNG-Pic.png"); /* Light background color */
            background-size: cover;
        }
        .profile-card .card-body {
            color:white; /* Set text color to white */
            text-transform: uppercase; /* Convert text to uppercase */
            font-weight:bold; /* Set text to bold */
            font-size: 18px;
        }


        .booking-report-card {
            height: 100%; /* Full height for the booking report card */
            background-color: wheat; /* Lighter background color */
        }

        .card-title {
            color: white; /* Dark text color */
        }

        /* Styling buttons */
        .btn-primary {
            background-color: #007bff; /* Bootstrap primary color */
            border-color: #007bff; /* Bootstrap primary border color */
        }
    </style>
</head>

<body>
<?php
if(isset($_SESSION["booking_success"])){?>
                  <script>
                      swal({
                        title: 'Booking Done',
                        text: 'Our executive will reach you shortly',
                        icon: 'success'
                      });
                    </script>;
<?php }
unset($_SESSION["booking_success"]);
?>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand me-auto" href="#">WePlan</a>
      
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="event.php">EVENTS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="gallery.php">GALLERY</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="user_profile.php">PROFILE</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="#" onclick="redirectToFooter()">VISIT US</a>
    
            </li>
            
          </ul>
        </div>
      </div>
      <?php
      if(isset($_SESSION['login'])){
      ?>
      <a href="logout.php" class="login-button">LOGOUT</a>
    <?php
      }else{
    ?>
        <a href="login.php" class="login-button">USER</a>
        <div class="p-1">
        <a href="adminlogin.php" class="login-button">ADMIN</a>
        </div>
    <?php }?>
        
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
       data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Left side - User Profile -->
            <div class="col-md-4 full-height">
                <div class="card profile-card rounded-0">
                    <div class="card-body profile-card ">
                        
                        <p><strong>Username: </strong><?php echo $name; ?></p>
                        <p><strong>Email: </strong> <?php echo $email; ?></p>
                        <p><strong>Phone Number: </strong> <?php echo $phone; ?></p>
                    </div>
                </div>
            </div>
      
            <!-- Right side - Space for Booking Report PDF -->
            
            <div class="col-md-8 full-height">


   <div class="card h-100 booking-report-card rounded-0">
   <div style="height: 100vh; overflow: auto;">
   <div class="card-body">
        
        
        <!-- Table to display booking details -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>SL NO</th>
                    <th>Event Name</th>
                    <th>Username</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Services</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                      
                    // Query to fetch booking details using booking_id
                    //$booking_id = $_SESSION["booking_success"];
                    $serial = 1;
                    $query = "SELECT * FROM events_booking WHERE email = '$email'";
                    $result = mysqli_query($conn, $query);
                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            // Output each booking detail as a table row
                            echo "<tr>";
                            echo "<td>".$serial."</td>";
                            echo "<td>{$row['event_name']}</td>";
                            echo "<td>{$row['username']}</td>";
                            echo "<td>{$row['from_date']}</td>";
                            echo "<td>{$row['to_date']}</td>";
                            echo "<td>{$row['services_selected']}</td>";
                            echo "<td>{$row['description']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>";
                            if($row["status"] == "approved"){
                            // Create a button to go to generate_pdf.php with the booking_id as a URL parameter
                            echo "<a href='generate_pdf.php?booking_id={$row['booking_id']}' class='btn btn-primary'>Generate PDF</a>";
                            }
                            echo "</td>";
                            echo "</tr>";

                            $serial++;
                        }
                       
                    } else {
                        // Display a message if no booking details are found
                        echo "<tr><td colspan='8'>No booking details found.</td></tr>";
                    }
                
                
                ?>
            </tbody>
        </table>
        
        <!-- Optionally, you can add a button to refresh or load more booking details -->
    </div>
  </div>
   
</div>

</div>

        </div>
    </div>
<?php include("footer.php") ?>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
