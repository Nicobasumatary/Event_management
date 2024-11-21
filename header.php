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
            <?php
            if(isset($_SESSION['login'])){
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
  