<?php include("dbconnect.php");
session_start();
if(isset($_SESSION['login'])){
    header('location:index.php');
}
?>

<?php
// if(isset($_POST['generate_otp'])){
//     // Account details

//     $apiKey = 'MzM0ZjQ2Nzc2NDZjNzg0NDM2Mzc2YTY5MzkzODY1NmU='; // Replace 'your_api_key' with your actual API key
//     $name = $_POST['username'];
//     $phone = $_POST['phnno'];
//     $otp = rand(1000, 9999);
//     $msg = "Hello ".$name.", Your OTP is ".$otp;

//     // Message details
//     $numbers = array($phone);
//     $sender = 'WePlan'; // Replace 'WePlan' with your desired sender ID
//     $message = urlencode($msg);

//     $numbers = implode(',', $numbers);

//     // Prepare data for POST request
//     $data = array(
//         'apikey' => $apiKey,
//         'numbers' => $numbers,
//         'sender' => $sender,
//         'message' => $message
//     );

//     // Send the POST request with cURL
//     $ch = curl_init('https://api.textlocal.in/send/');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($ch);
//     curl_close($ch);

//     // Process your response here
//     echo $response;
//     echo "Otp Sent Success";
// }else{
//     echo "error";
// }
?>



<?php
if(isset($_POST["submit"])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phoneno = $_POST['phnno'];
    $errors = array();
    //$errors_validate = array();

    // Check if the email field is empty
    // if(empty($email)){
    //     array_push($errors,'Email field cannot be empty');
    // }


    if(empty($username) || empty($password) || empty($phoneno) || empty($email)){
        array_push($errors,'All fields are required');
    }

    // Validate the email format
    // if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //     array_push($errors,'Email is not valid');
    // }

    // Validate password length
    if(strlen($password) < 8){
        array_push($errors,'Password must be 8 characters long');
    }
    if(strlen($phoneno) !== 10){
        array_push($errors,'Phone Number should be of 10 digits');
    }

    //Checking if email already exists
    $sql = "SELECT * FROM user_regis WHERE email = ?";
    $stmt = mysqli_stmt_init($conn); //Initializes new statement object to $stmt 
    if (mysqli_stmt_prepare($stmt, $sql)) { //prepares the statement and checks if the statement is without error
        mysqli_stmt_bind_param($stmt, "s", $email); // binds the parameter 
        mysqli_stmt_execute($stmt); //executes the statement
        $result = mysqli_stmt_get_result($stmt);
        $count_rows = mysqli_num_rows($result);
        if ($count_rows > 0) {
            array_push($errors, "The email already exists");
        }
    }
    $sql = "SELECT * FROM user_regis where phnno = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $phoneno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $count_rows = mysqli_num_rows($result);
        if($count_rows > 0){
            array_push($errors,"The phone number already exist");
        }
    }

    // If there are no errors, proceed with insertion
    if(count($errors) == 0){
        // Hash the password before storing it in the database
        //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO user_regis (username, password, email, phnno) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);
        
        if($prepare_stmt){
            mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $email, $phoneno);
            mysqli_stmt_execute($stmt);
            //echo "Registration Success";
            $_SESSION['registered'] = true;
            header("location:login.php");
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
    <title>Registration</title>
    <link rel="stylesheet" href="Registration.css">
    <style>
    .backdrop .error{
    color: whitesmoke;
    text-align: center;
}</style>
</head>
<body>
    <div class="backdrop">
        <form method="POST" action="register.php">
            <h1>Sign Up</h1>
            <div class="inputbox">
                <input type="text" placeholder="Username" name="username">
            </div>
            <div class="inputbox">
                <input type="email" placeholder="Email" name="email">
            </div>
            <div class="inputbox">
                <input type="number" placeholder="Phone No." name="phnno">
                
            </div>
            
            <div class="inputbox">
                <input type="password" placeholder="Password" name="password">
            </div>
            <div class="error">
                <?php 
                    if(!empty($errors)){
                        foreach($errors as $error){
                            echo $error. "<br>";
                            //echo $errors_validate;
                        }
                    }
                ?>
            </div>
            <button type="submit" class="btn" name="submit">Register</button>
            <div class="sign_in">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
            
            
        </form>
    </div>
</body>
</html>
