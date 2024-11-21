<?php
include('dbconnect.php');
include('function.php');
session_start();

$pendingBookings = getPendingBookings($conn);
$numRows = count($pendingBookings);

if(isset($_POST['edit'])){
    $event_id = $_POST['event_id'];
    $sql = "select * from events_list where event_id = $event_id";
    $execute = mysqli_query($conn,$sql);
    if($execute){
        $data = mysqli_fetch_assoc($execute);
    }
}

if(isset($_POST['change'])){
    $event_id = $_POST['event_id'];
    $event_name = $_POST['eventname'];
    $description = $_POST['eventDescription'];
    $img = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name']; 
    $price = $_POST['price'];

    // Prepare the SQL statement with placeholders
    $sql = "UPDATE events_list SET event_name = ?, description = ?, img_url = ?, price = ? WHERE event_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssssi", $event_name, $description, $img, $price, $event_id);

    // Execute the statement
    $execute = $stmt->execute();
    
    if($execute){
        move_uploaded_file($temp_name, "picture/$img");
        $_SESSION['updated'] = true;
        header('location:view_events.php');
    }else{
        echo "image not uploaded";
    }
    
    // Close the statement
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_header_style2.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>

<div class="container-fluid p-0 d-flex h-100">
<div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-success text-white offcanvas-md offcanvas-start" style="width: 230px;">
            <a href="#" class="navbar-brand">
                <h5>WEPLAN<h5> <br>
                <h5>
                <?php
                if(isset($_SESSION['signin'])){
                    echo htmlentities($_SESSION['signin']);}
                ?>

                </h5>
                
            </a>
            <hr>
            <ul class="mynav nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                    <a href="add_admin.php" class="">
                    MANAGE ADMIN
                    </a>
                </li>
            <li class="nav-item mb-1">
                    <a href="admin_index.php" class="">
                        DASHBOARD
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="users.php" class="">
                        USERS
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="admin_booking_list.php" class="">
                        BOOKINGS
                        <span class="notification-badge"><?php echo $numRows;  ?></span>
                    </a>
                </li>
                <li class="nav-item mb-1">
    <div class="dropdown">
        <a class="nav-item dropdown-toggle" href="#" role="button" id="manageEventsDropdown" data-bs-toggle="dropdown" aria-expanded="true">
            MANAGE EVENTS
        </a>
        <ul class="dropdown-menu bg-success" aria-labelledby="manageEventsDropdown">
            <li>
                
                
                    <ul class="list-unstyled">
                        <li><a class="dropdown-item text-white" href="view_events.php">VIEW EVENTS</a></li>
                        <li><a class="dropdown-item text-white" href="view_services.php">VIEW SERVICES</a></li>
                        <li><a class="dropdown-item text-white" href="add_events.php">ADD EVENTS</a></li>
                        <li><a class="dropdown-item text-white" href="add_services.php">ADD SERVICES</a></li>
                        <!-- Add more options as needed -->
                    </ul>
                
            </li>
        </ul>
    </div>
</li>
                <li class="nav-item mb-1">
                    <a href="manage_gallery.php" class="">
                        MANAGE GALLERY
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="manage_page.php" class="">
                        MANAGE PAGES
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="view_feedback.php" class="">
                        VIEW FEEDBACKS
                    </a>
                </li>
                <?php
                if(isset($_SESSION['signin'])){
                ?>
                <li class="nav-item mb-1">
                    <a href="logout.php" class="">
                        LOGOUT
                    </a>
                <?php }?>
                </li>
            </ul>
            <hr>
            
        </div>
        <div class="bg-light flex-fill">
            <div class="p-2 d-md-none d-flex text-white bg-success">
                <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                    <i class="fa-solid fa-bars"></i>
                </a>
                
            </div>
            <div class="p-4">
                <div class="row">
                    <div class="col">
                        <h5>EDIT EVENTS</h5><br><br>
                        <div style="max-height: 80vh; overflow: auto;">
         
        <div class="container">
   
    <form action="edit_events.php" method="POST" enctype = "multipart/form-data">
    <input type="hidden" name="event_id" value = "<?php echo $data['event_id']?>">
      <div class="mb-3">
        <label for="eventName" class="form-label">Event Name:</label>
        <input type="text" class="form-control" id="eventName" name="eventname" value="<?php echo $data['event_name']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="eventDescription" class="form-label">Event Description:</label>
        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" required><?php echo $data['description']; ?></textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        <input type="file" class="form-control" name="image" value="<?php echo $data['img_url'];?>"required>
    </div>

      <div class="mb-3">
        <label for="eventName" class="form-label">Price:</label>
        <input type="text" class="form-control" id="eventName" name="price" value="<?php echo $data['price']; ?>" required>
      </div>
      <button type="submit" name = 'change'class="btn btn-primary">Submit</button>
    </form>
  </div>
        </div>
        </div>
        </div>
</div>
                
            </div>
            
        </div>

        
    </div>
            
        </div>
</div>
</body>
</html>