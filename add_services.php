<?php
include ("dbconnect.php");
include ("function.php");
session_start();
if(!isset($_SESSION['signin'])){
    header("location: index.php");
}

$pendingBookings = getPendingBookings($conn);
$numRows = count($pendingBookings);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WePlan-Add_Services</title>
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
                text: "Service Uploaded",
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
                    <br><br>
                    <!--<div class="dropdown">
                <select class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Event
                </select>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
                </div>-->



                    <div class="container">
                        <h3>ADD SERVICE</h3>


                        <form action="service_submit.php" method="POST">
                            <?php
                            $sql = "select * from events_list";
                            $execute = mysqli_query($conn, $sql);
                            $check_list = mysqli_num_rows($execute) > 0;
                            if ($check_list) { ?>
                                <div class="form-group">

                                    <label for="type">EVENT NAME:</label><br>
                                    <select class="form-control mt-2" name="result" id="type">
                                        <?php while ($row = mysqli_fetch_assoc($execute)) { ?>
                                            <option><?php echo $row['event_id']; ?>---
                                                <?php echo $row['event_name']; ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="additional_info">SERVICE NAME:</label><br>
                                    <input type="text" class="form-control mt-2" id="additional_info" name="additional_info[]"
                                        required><br>
                                </div>

                                <!-- Container for additional service information fields -->
                                <div id="additionalInfoFields" class="mb-2"></div>

                                <!-- Buttons -->
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="addAdditionalInfoField()">Add
                                        More</button>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="closeAdditionalInfoField()">Close</button><br><br>
                                </div>

                                <input type="submit" name="submit_service" class="btn btn-success" value="Submit">
                            </form>
                            <?php
                            }
                            ?>
                    </div>

                    <script>
                        function addAdditionalInfoField() {
                            var container = document.getElementById("additionalInfoFields");
                            var input = document.createElement("input");
                            input.type = "text";
                            input.className = "form-control mb-2";
                            input.name = "additional_info[]";
                            input.required = true;
                            container.appendChild(input);
                            container.appendChild(document.createElement("br"));

                        }

                        function closeAdditionalInfoField() {
                            var container = document.getElementById("additionalInfoFields");
                            var inputs = container.getElementsByTagName("input");
                            var brs = container.getElementsByTagName("br");
                            if (inputs.length > 0) {
                                container.removeChild(inputs[inputs.length - 1]);
                                container.removeChild(brs[brs.length - 1]);

                            }
                        }
                    </script>



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