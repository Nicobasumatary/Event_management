<?php
include ('dbconnect.php');
include ("function.php");
session_start();
if(!isset($_SESSION['signin'])){
    header("location: index.php");
}
$pendingBookings = getPendingBookings($conn);
$numRows = count($pendingBookings);

if (isset($_POST['upload'])) {
    $name = $_POST['name'];
    $descript = $_POST['description'];
    $img = $_FILES['image']['name'];
    $price = $_POST['price'];
    $temp_name = $_FILES['image']['tmp_name'];

    $name = mysqli_real_escape_string($conn, $name);
    $descript = mysqli_real_escape_string($conn, $descript);


    $target_directory = 'picture/';
    $target_file = $target_directory . basename($img);


    if (move_uploaded_file($temp_name, $target_file)) {

        $stmt = $conn->prepare("INSERT INTO events_list (event_name, description, img_url, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $descript, $target_file, $price);

        if ($stmt->execute()) {
            $_SESSION['uploaded'] = true;
            header("Location: add_events.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<, initial-scale=1.0">
    <title>WePlan-Add Events</title>
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
</head>

<body>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    if (isset($_SESSION['uploaded'])) { ?>
        <script>
            swal({
                title: "",
                text: "Event Uploaded",
                icon: "",
            }); 
        </script>
        <?php
        unset($_SESSION['uploaded']);
        ?>
    <?php }
    ?>


    <div class="container-fluid p-0 d-flex h-100">
        <div id="bdSidebar"
            class="d-flex flex-column flex-shrink-0 p-3 bg-success text-white offcanvas-md offcanvas-start"
            style="width: 230px;">
            <a href="#" class="navbar-brand">
                <h5>WEPLAN<h5> <br>
                        <h5>
                            <?php
                            if (isset($_SESSION['signin'])) {
                                echo htmlentities($_SESSION['signin']);
                            }
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
                        <span class="notification-badge"><?php echo $numRows;

                        ?></span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <div class="dropdown">
                        <a class="nav-item dropdown-toggle" href="#" role="button" id="manageEventsDropdown"
                            data-bs-toggle="dropdown" aria-expanded="true">
                            MANAGE EVENTS
                        </a>
                        <ul class="dropdown-menu bg-success" aria-labelledby="manageEventsDropdown">
                            <li>


                                <ul class="list-unstyled">
                                    <li><a class="dropdown-item text-white" href="view_events.php">VIEW EVENTS</a></li>
                                    <li><a class="dropdown-item text-white" href="view_services.php">VIEW SERVICES</a>
                                    </li>
                                    <li><a class="dropdown-item text-white" href="add_events.php">ADD EVENTS</a></li>
                                    <li><a class="dropdown-item text-white" href="add_services.php">ADD SERVICES</a>
                                    </li>
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
                if (isset($_SESSION['signin'])) {
                    ?>
                    <li class="nav-item mb-1">
                        <a href="logout.php" class="">
                            LOGOUT
                        </a>
                    <?php } ?>
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
                        <h5>ADD EVENTS</h5>
                        <div class="row">
                            <div class="col">
                                <form action="add_events.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Event Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description:</label>
                                        <textarea class="form-control" id="description" name="description"
                                            required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image:</label>
                                        <input type="file" class="form-control" id="image" name="image" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Price:</label>
                                        <textarea class="form-control" id="description" name="price"
                                            required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="upload">Submit</button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>


    </div>
</body>