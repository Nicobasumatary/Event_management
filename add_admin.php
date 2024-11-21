<?php
include ('dbconnect.php');
include ("function.php");
session_start();
if(!isset($_SESSION['signin'])){
    header("location: index.php");
}
$query = "select * from user_regis";
$result = mysqli_query($conn, $query);

$pendingBookings = getPendingBookings($conn);
$numRows = count($pendingBookings);
?>


<?php
if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = array();

    if (empty($email) || empty($password)) {
        array_push($errors, 'All fields are required');
    }

    // Validate password length
    if (strlen($password) < 8) {
        array_push($errors, 'Password must be at least 8 characters long');
    }

    // Checking if email already exists
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count_rows = mysqli_num_rows($result);
        if ($count_rows > 0) {
            array_push($errors, "The email already exists");
        }
    }

    // If there are no errors, proceed with insertion
    if (count($errors) == 0) {
        // Hash the password before storing it in the database
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (email, password) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $email, $password);
            mysqli_stmt_execute($stmt);
            //echo "Registration Success";
            $_SESSION['success'] = true;
            header("location:add_admin.php");
            exit();
        } else {
            die("Something went wrong");
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<, initial-scale=1.0">
    <title>Add Admin</title>
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
    <style>
        .modal-backdrop {
            z-index: 1050;
            /* Ensure modal backdrop covers entire viewport */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(email) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                target: '#user-table'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_admin.php?result=' + email;
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                }
            });
        }
    </script>

</head>

<body>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    if (isset($_SESSION['success'])) { ?>
        <script>
            swal({
                title: "",
                text: "New Admin Added",
                icon: "success",
            });
        </script>
        <?php
        unset($_SESSION['success']);
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
                        <span class="notification-badge"><?php echo $numRows; ?></span>
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
            <div style="height: 100vh; overflow: auto;">
                <div class="p-4">
                    <div class="row">
                        <div class="col">
                            <h5>ADD ADMIN</h5>
                            <br><br>
                            <div class="row">
                                <div class="col">
                                    <div class="container">

                                        <form action="add_admin.php" method="POST">

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required>
                                            </div>
                                            <div class="error">
            <?php
                if(!empty($errors)){
                    echo implode("<br>", $errors);
                }
                ?>
                
            </div>
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>

                                    <div class="mt-5">
                                        <table class="table table-bordered tex-centered">
                                            <tr class="bg-dark text-white">
                                                <td>SL NO</td>
                                                <td>EMAIL</td>
                                                <td>ACTION</td>

                                            </tr>
                                            <?php
                                            $sql = "select * from admin";
                                            $execute = mysqli_query($conn, $sql);
                                            $serial = 1;
                                            while ($row = mysqli_fetch_assoc($execute)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $serial; ?></td>

                                                    <td><?php echo $row['email']; ?></td>

                                                    <td>
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete('<?php echo $row['email']; ?>')">
                                                            DELETE</button>
                                                    </td>
                                                </tr>
                                                <?php
                                                $serial++;
                                            }
                                            ?>
                                        </table>

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