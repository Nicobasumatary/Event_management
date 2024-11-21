<?php
include ('dbconnect.php');
session_start();
if (isset($_POST['eventsubmit'])) {
  $event_id = $_POST['result'];
  $query = "select * from events_list where event_id = $event_id";
  $execute = mysqli_query($conn, $query);
  if ($execute) {
    $data = mysqli_fetch_assoc($execute);
  }
}
 if(empty($event_id)) {
   header("location: event.php");
 }

// $event_id = $_GET['result'];
// $query = "select * from events_list where event_id = $event_id";
// $execute = mysqli_query($conn,$query);
// if($execute){
//     $details = mysqli_fetch_assoc($execute);
//      //echo $event_id;
//      //echo $details['description'];

// }

// if (isset($_POST['book'])) {

//   $event_id = $_POST['event_id'];
//   $event_name = $_POST['event_name'];
//   $descript = $_POST['description'];

//   //$sql = "select * from events_list where event_id = ";
//   if (isset($_SESSION['login'])) {
//     $email = $_SESSION['login'];
//     $query = "SELECT * FROM user_regis WHERE email = '$email'";
//     $execute = mysqli_query($conn, $query);
//     if ($execute) {
//       $data = mysqli_fetch_assoc($execute);
//       $userid = $data['u_id'];
//       $user_email = $data['email'];
//       $username = $data['username'];
//       $phone = $data['phnno'];
//     }

//   }
//   $sql = "INSERT INTO events_booking VALUES (NULL, ?, ?, ?, ?, ?, ?)";
//   $stmt = mysqli_prepare($conn, $sql);

//   if ($stmt) {
    
//     mysqli_stmt_bind_param($stmt, "iissis", $event_id, $userid, $username, $user_email, $phone, $descript);

//     // Attempt to execute the prepared statement
//     if (mysqli_stmt_execute($stmt)) {
//       $_SESSION['booking_success'] = true;
//       mysqli_stmt_close($stmt);
//       header("Location:event.php");
//       exit();




//     }
//     // Close the statement
//     mysqli_stmt_close($stmt);
//   }

// }
?>

<!DOCTYPE html>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WePlan-Event Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="admin_header_style2.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <!--<link href="style.css" rel="stylesheet">-->
  <!--<link  href="lando.css" rel="stylesheet">-->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function redirectToFooter() {
      // Scroll to the footer
      document.getElementById('footer').scrollIntoView({ behavior: 'smooth' });
    }
  </script>
</head>
<style>
/*nav*/
.navbar{
    background-color: #ffffff;
    height: 80px;
    margin: 20px;
    border-radius: 16px;
}
.navbar-brand{
    font-weight: 500;
    color: #009970;
    font-size: 24px;
    transition: 0.3s color;
    
}

.login-button{
    background-color: #009970;
    color: #fff;
    font-size: 14px;
    padding: 8px 20px;
    border-radius: 50px;
    text-decoration: none;
    transition: 0.3s background-color;
}
.login-button:hover{
    background-color: #00b383;
}
.navbar-toggler{
    border: none;
    font-size: 1.25rem;
}
.navbar-toggler:focus .btn-close:focus{
    box-shadow: none;
    outline: none;
}
.nav-link{
    color: #666777;
    font-weight: 500;
    position: relative;
}
.nav-link:hover .nav-link.active{
    color:#000;
}
@media(min-width:991px){
.nav-link::before{
    content:"";
    position:absolute;
    bottom:0;
    left: 50%;
    transform:translateX(-50%);
    width: 0;
    height: 2px;
    background-color: #009970;
    visibility: hidden;
    transition: 0.3s ease-in-out;
}
.nav-link:hover::before, .nav-link.active::before{
    width: 100%;
    visibility: visible;

}
}

/*img*/

*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

.backdrop{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    
    
}
.backdrop .area{
    width: 100%;
    height: auto;
    background: wheat;
    padding: 10px;
}
.backdrop .area p{
    margin: 10px;
}
.hero-section{
    background:linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,0)), url(2744546c-3801-4474-9e14-ebefc3241be7.jpg) no-repeat center;
    background-size: cover;
    width: 100%;
    height: 80vh;

}


</style>
<body>
  <!--Navbar-->
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
      if (isset($_SESSION['login'])) {
        ?>
        <a href="logout.php" class="login-button">LOGOUT</a>
        <?php
      } else {
        ?>
        <a href="login.php" class="login-button">USER</a>
        <div class="p-1">
          <a href="adminlogin.php" class="login-button">ADMIN</a>
        </div>
      <?php } ?>

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
  <div class="hero-section" style="background-color:transparent; background: url(2744546c-3801-4474-9e14-ebefc3241be7.jpg)">
    <div class="hero-section d-flex justify-content-center align-items-center">
      <div class="card text-center" style="background-color: transparent; border:none;">
        <div class="card-body">
          <p class="card-text fs-5">

            <span
              style="font-style:none; font-weight: bold; font-size: 79px; color: #66cdaa;"><?php echo $data['event_name']; ?></span><br>


          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="card text-center">
    <div class="card-body">
      <p class="card-text fs-5">
        <?php
        if (isset($data)) {
          echo $data['description'];
        }

        ?>
      </p>
      <p class="card-text fs-5">
      <h3>Budget</h3>
      <h5>The Price can be adjusted depending on the requirements</h5>
      <h4>
        <?php
        if (isset($data)) {
          echo $data['price'];
        }

        ?>
      </h4>
      </p>
      <br><br>
      Click Proceed to Continue with your Booking
      <br><br>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <!--<button type="submit" class="btn btn-primary" name="book">BOOK</button>-->
        PROCEED
      </button>
    </div>
  </div>



  <?php
  if (isset($_SESSION['login'])) { ?>
    <!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    EDIT
  </button>-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!--Form to submit booking-->
            <form method="POST" action="booking.php">
              <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
              <input type="hidden" name="event_name" value="<?php echo $data['event_name']; ?>">
              <?php
              $query = "select * from services where event_id = $event_id";
              $execute = mysqli_query($conn, $query);
              ?>

              <?php
              while ($data = mysqli_fetch_assoc($execute)) {
                ?>
                <div class="form-group">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="service[]"
                      value="<?php echo $data['service_name']; ?>">
                    <label class="form-check-label" for="exampleCheck1"
                      required><?php echo $data['service_name']; ?></label>

                  </div>
                </div><br>
              <?php } ?>

              <!-- Date input -->
             
            <div class="form-group">
                <label for="exampleDate">From Date</label>
                <input type="date" class="form-control" name="fromdate" min="<?php echo date('Y-m-d',strtotime('+1 days')); ?>" id="exampleDate" required>
              </div><br>

              <div class="form-group">
                <label for="exampleDate">To Date</label>
                <input type="date" class="form-control" name="todate" min="<?php echo date('Y-m-d',strtotime('+1 days')); ?>" id="exampleDate" required>
              </div><br> 


              <?php
    if(isset($_SESSION["booking_error"])) {
        echo '<div class="alert alert-danger">' . $_SESSION["booking_error"] . '</div>';
        unset($_SESSION["booking_error"]); 
    }
?>


              <!-- Textarea -->
              <div class="form-group">
                <label for="exampleTextarea">Message</label>
                <textarea class="form-control" id="exampleTextarea" rows="3" name="description"
                  placeholder="Additional Info"></textarea>
              </div><br>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="book">BOOK</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>






    <!--<div class="form-floating">
    </div>
    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description"></textarea>
    <label for="floatingTextarea2"></label>
    <button type="submit" class="btn btn-primary" name="book" data-bs-toggle="modal" data-bs-target="#exampleModal">
            BOOK
        </button>
    <button type="submit"  class="login-button">BOOK</button>
    </form>-->
    <?php
  }
  if (!isset($_SESSION['login'])) { ?>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">

      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Select the Services</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <form>
              <input type="hidden" name="event_id">

              <form method="POST" action="events_details.php">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <?php
                $query = "select * from services where event_id = $event_id";
                $execute = mysqli_query($conn, $query);
                ?>

                <?php
                while ($data = mysqli_fetch_assoc($execute)) {
                  ?>
                  <div class="form-group">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1"
                        required><?php echo $data['service_name']; ?></label>
                    </div>
                  </div><br>
                <?php } ?>

                <!-- Date input -->
                <div class="form-group">
                  <label for="exampleDate">From Date</label>
                  <input type="date" class="form-control" name="fromdate"  min="<?php echo date('Y-m-d',strtotime('+1 days')); ?>" id="exampleDate" required>
                </div><br>

                <div class="form-group">
                  <label for="exampleDate">To Date</label>
                  <input type="date" class="form-control" name="todate"  min="<?php echo date('Y-m-d',strtotime('+1 days')); ?>" id="exampleDate" required>
                </div><br>

                <!-- Textarea -->
                <div class="form-group">
                  <label for="exampleTextarea">Message</label>
                  <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Additional Info"
                    required></textarea>
                </div><br>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
            <a href="login.php"><button type="button" class="btn btn-primary">BOOK</button></a>
          </div>
          </form>
        </div>
      </div>
    </div>


    <!--<a href="login.php" class="login-button">BOOK</a>-->
    <?php
  }
  ?>
  <?php
  include ("footer.php");
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>