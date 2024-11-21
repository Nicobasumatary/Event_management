<?php
// Include database connection and start session
include('dbconnect.php');
session_start();

// Query to select image URLs from the gallery table
$sql = "SELECT image_url FROM gallery";
$result = mysqli_query($conn, $sql);

// Fetch image URLs from the database and store them in an array
$imageUrls = array();
while ($row = mysqli_fetch_assoc($result)) {
    $imageUrls[] = $row['image_url'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WePlan Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <script>
        function redirectToFooter() {
            // Scroll to the footer
            document.getElementById('footer').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
    <style>
        body {
            background:wheat;
        }

        .custom-container {
            margin-top: 120px; /* Adjust as needed */
        }
    </style>
</head>
<body>
    
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
    
    <div class="container-fluid custom-container">
    
        <div class="row row-cols-1 row-cols-md-3 g-3" id="gallery">
           
            <?php
            // Display maximum 6 images initially
            $numImagesToDisplay = min(count($imageUrls), 6);
            for ($i = 0; $i < $numImagesToDisplay; $i++):
            ?>
            <div class="col mb-4">
                <div class="card">
                    <img src="<?php echo $imageUrls[$i]; ?>" class="card-img-top" alt="Image" style="width: 100%; height: 200px; object-fit: cover;">
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <?php if (count($imageUrls) > 6): ?>
        <div class="text-center mt-4 mb-2">
            <button class="btn btn-primary" id="loadMoreBtn">MORE</button>
        </div>
        <?php endif; ?>
    </div>
    

    <?php
    include('footer.php');
    ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Counter to keep track of the number of images already loaded
        var numImagesLoaded = <?php echo $numImagesToDisplay; ?>;

        // Function to load more images
        function loadMoreImages() {
    var gallery = document.getElementById('gallery');
    <?php
    
    $startIndex = $numImagesToDisplay;
    $endIndex = min($startIndex + 6, count($imageUrls));
    ?>
    <?php for ($i = $startIndex; $i < $endIndex; $i++): ?>
    var imageUrl = '<?php echo $imageUrls[$i]; ?>';
    var col = document.createElement('div');
    col.classList.add('col');
    var card = document.createElement('div');
    card.classList.add('card');
    var img = document.createElement('img');
    img.classList.add('card-img-top');
    img.src = imageUrl;
    img.alt = 'Image';
    img.style.width = '100%'; 
    img.style.height = '200px'; 
    img.style.objectFit = 'cover'; 
    card.appendChild(img);
    col.appendChild(card);
    gallery.appendChild(col);
    numImagesLoaded++;
    <?php endfor; ?>
    // Hide the "Load More" button if all images are loaded
    if (numImagesLoaded >= <?php echo count($imageUrls); ?>) {
        document.getElementById('loadMoreBtn').style.display = 'none';
    }
}

        // Load more images when the "Load More" button is clicked
        document.getElementById('loadMoreBtn').addEventListener('click', loadMoreImages);
    </script>
</body>
</html>
