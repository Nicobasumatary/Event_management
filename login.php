<?php
include("dbconnect.php");
session_start(); // Start the session
if(isset($_SESSION['login'])){
    header('location:index.php');
}
$errors = array();
if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("select * from user_regis where email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows>0){
        $data = $stmt_result->fetch_assoc();
        if($data['password'] == $pass && $data['email'] == $email){
            $_SESSION["login"] = $_POST["email"];
            // Redirect to another page
            header('location:index.php');
            exit(); 
        } else {
            $errors[] = 'Invalid login credentials';
        }
    } else {
        $errors[] = 'Invalid login credentials';
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="Login.css">
    
</head>
<body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if(isset($_SESSION['registered'])) {?>
    <script>
            swal({
              title: 'Registration Done',
              text: ' Now Login to your account',
              icon: ''
            })
          </script>
    
<?php
}
unset($_SESSION['registered']);
?>  
    <div class="wrapper">
        <form action="login.php" method="POST">
            <h1>Login</h1>
            <div class="inputbox">
                <input type="text" placeholder="Email" name="email" required>
            </div>
            <div class="inputbox">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="error">
            <?php
                if(!empty($errors)){
                    echo implode("<br>", $errors);
                }
                ?>
                
            </div>
            <button type="submit" class="btn" name="login">Login</button>
            <div class="register">
                <p>Don't have an account? <a href="register.php">Register</a></p><br>
                <div class="back">
                <p> Go back to Home Page. <a href="index.php">GoBack</a></p>
            </div>
            </div>
        
            
        </form>
    </div>
</body>
</html>