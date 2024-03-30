<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "smartstudy";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Check if user exists in Users table
    $checkUserQuery = "SELECT * FROM Users WHERE Username='$username'";
    $userResult = $conn->query($checkUserQuery);
    
    if ($userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $userRow["Password"])) {
            $_SESSION["user_type"] = $userRow["UserType"];
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $userRow["UserID"]; // Set user_id in the session

            // Set cookies
            setcookie("user_type", $userRow["UserType"], time() + (86400 * 30), "/");
            setcookie("username", $username, time() + (86400 * 30), "/");
            setcookie("user_id", $userRow["UserID"], time() + (86400 * 30), "/"); // Set user_id in cookies
            
            // Redirect to the homepage (adjust the URL accordingly)
            header("Location: homepage.php");
            exit();
        } else {
            $loginError = true; // Flag to show login error message
        }
    } else {
        $loginError = true; // Flag to show login error message
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartStudy</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS for button hover effect -->
    <style>
        .btn-primary:hover {
            background-color: #007bff;
        }
    </style>
</head>
<body style="background-color: #000; color: #fff;" class="bd-dark text-white">
    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-tabs" style="background-color: black !important;">
        <a class="navbar-brand" href="all_books.php" style="padding: 0;">
            <span style="display: inline-block; width: 150px; height: 40px; background: url('cover.png') no-repeat center center; background-size: cover; border-radius: 90px;"></span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="register.php">নতুন রেজিস্টার
                           <!-- <img src="register.png" alt="Register Icon" style="width: 30px; height: 25px;"> -->
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">প্রবেশ করুন
                           <!-- <img src="login.png" alt="Login Icon" style="width: 30px; height: 30px;"> -->
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- Login Form -->
    <div class="container mt-4">
        <h2>প্রবেশ করুন</h2>
        <?php if (isset($loginError) && $loginError) : ?>
            <div class="alert alert-danger">Invalid login credentials</div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">ব্যবহারকারীর নাম:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">পাসওয়ার্ড:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">প্রবেশ করুন</button>
        </form>
    </div>
    <!-- Footer -->
    <footer class="footer fixed-bottom text-center" style="background-color: blue !important;">
        <!-- Footer content -->
    </footer>
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
