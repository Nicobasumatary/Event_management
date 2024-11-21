<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WePlan-Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php
include('dbconnect.php');
session_start();
if(isset($_SESSION['submitted'])) {?>
    <script>
            swal({
              title: '',
              text: 'Feedback Submitted',
              icon: 'success'
            });
          </script>
<?php
} unset($_SESSION['submitted']);
?>  
<?php
if(isset( $_SESSION['booking_error'])) {?>
    <script>
            swal({
              title: 'Error',
              text: 'Invalid date range. Please select valid dates.',
              icon: 'error'
            });
          </script>
<?php
} unset( $_SESSION['booking_error']);
?> 



<script>
    function redirectToFooter() {
        document.getElementById('footer').scrollIntoView({ behavior: 'smooth' });
    }
</script>
    
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
                        <?php if(isset($_SESSION['login'])){
            ?>
            <li class="nav-item">
              <a class="nav-link mx-lg-2" href="user_profile.php">PROFILE</a>
            </li>
            <?php } ?>
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
  <div class="hero-section"style="background-color: transparent; ">
  
    <div class="hero-section d-flex justify-content-center align-items-center">
        <div class="card text-center" style="background-color: transparent; border:none;">
            <div class="card-body">
                <p class="card-text fs-5">
                    <span style="font-style:italic; font-weight: bold; font-size: 80px; color: wheat;">Welcome to WePlan</span><br>
                    <span style="font-style: italic; font-size: 24px; color: rgb(255, 255, 255);">Discover Events</span>
                </p>
            </div>
        </div>
        
    </div>
    <div class = "d-flex justify-content-center align-items-center p-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-weight: bold;">
    Submit Feedback
</button>

    </div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<?php if(isset($_SESSION['login'])) { ?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="feed.php"method = "POST">
      <div class="form-group">
        
                        <label for="message">Feedback: </label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Submit Your Feedback" required></textarea>
      
      </div>
      <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
    <button type="submit" class="btn btn-primary" name="feed_submit">SUBMIT</button>
  </div>
      </form>
    </div>
    </div>
    </div>
  </div>
  <?php } ?>
  <?php if(!isset($_SESSION['login'])) { ?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="feed.php"method = "POST">
      <div class="form-group">
        
                        <label for="message">Feedback: </label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Submit Your Feedback" required></textarea>
      
      </div>
      <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
    <a href = "login.php"><button type="button" class="btn btn-primary">SUBMIT</button></a>
  </div>
      </form>
    </div>
    </div>
    </div>
  </div>
  <?php } ?>
</div>

<div class="container-fluid px-0">
    
    <?php
    $query = "select * from events_list";
    $execute = mysqli_query($conn,$query);
    $check_event = mysqli_num_rows($execute) > 0; 
    if($check_event) {
    ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 m-5" data-aos="fade-up" data-aos-duration="4000">
            <?php while($row = mysqli_fetch_assoc($execute)){ ?>
                <div class="col">
                    <form method="POST" action="events_details.php">
                        <button type="submit" name="eventsubmit" class="btn">
                            <input type="hidden" name="result" value="<?php echo $row['event_id']; ?>">
                            <input type="hidden" name="event_name" value="<?php echo $row['event_name'];?>">
                            <div class="card rounded-0">
                                <img src="picture/<?php echo $row['img_url']?>" class="card-img-top rounded-0"style="width: 400px; height: 300px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title text-center"><?php echo $row['event_name']?></h5>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php include("footer.php"); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
