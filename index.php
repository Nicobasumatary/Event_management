<?php
include("dbconnect.php");
session_start();
$sql = "select * from feedback";
$execute = mysqli_query($conn,$sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
   rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link href="style.css" rel="stylesheet">
   <script>
        function redirectToFooter() {
            // Scroll to the footer
            document.getElementById('footer').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
<style>
    /* Custom CSS for carousel control icons */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      background-color: black; /* Change the color to red */
    }
  </style>
  

</head>
<body>
  <!--Navbar-->
    <?php
    include("header.php");
    ?>
<!--End-->
<div class="hero-section"style="background-color: transparent;">
    <div class="hero-section d-flex justify-content-center align-items-center">
        <div class="card text-center" style="background-color: transparent; border:none;">
            <div class="card-body">
                <p class="card-text fs-5">
                    <span style="font-style:italic; font-weight: bold; font-size: 80px; color: wheat;">Welcome to WePlan</span><br>
                    <span style="font-style: italic; font-size:24px; color: rgb(255, 255, 255);">Discover Amazing Events and Plan Your Next Celebration</span>
                </p>
            </div>
        </div>
    </div>
</div>


<?php

$sql = "SELECT * FROM pages";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){
?>

<div class="card text-center" style="background-color: transparent; border:none;">
            <div class="card-body">
                <p class="card-text fs-5">
                    
                    <span style="font-style: italic; font-size:24px; color: black;"><?php echo $row['description'] ?></span>
                </p>
            </div>
        </div>

<?php } ?>

<div class="container mt-4" style="background: transparent; text-align: center;">
    <h3>User Reviews</h3>
    <div id="feedbackCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php 
            $first = true;
            while($row = mysqli_fetch_assoc($execute)){ ?>
            <!-- Feedback Item -->
            <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                <div class="card m-3 w-50 h-auto" style="background: white; border: none; position: relative; left: 24%; transition: all 0.5s;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['username']; ?></h5>
                        <p class="card-text"><?php echo $row['feedback']; ?></p>
                    </div>
                </div>
            </div>
            <?php 
            $first = false;
            } ?>
        </div>
        <!-- Carousel Controls -->
        <a class="carousel-control-prev" href="#feedbackCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#feedbackCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!-- End Carousel Controls -->
    </div>
</div>



    <br>
  <?php
  include('footer.php');
  ?>
<!--Script-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
