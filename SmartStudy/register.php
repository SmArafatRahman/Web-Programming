<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <ul class="navbar-nav ml-auto"> <!-- Use ml-auto to push items to the right -->
                <li class="nav-item">
                    <a class="nav-link" href="register.php">নিবন্ধন
                      <!--  <img src="register.png" alt="Register Icon" style="width: 30px; height: 30px;"> -->
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"> প্রবেশ করুন
                        <!--<img src="login.png" alt="Login Icon" style="width: 30px; height: 30px;"> -->
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Registration Form -->
    <div class="container mt-4">
        <h2>নিবন্ধন</h2>
        <form method="post" action="register.php">

        <label for="username">ব্যবহারকারীর নাম:</label>
            <input type="text" class="form-control" id="username" name="username" required><br>

            <label for="user_type">ব্যবহারকারীর ধরন:</label>
            <select class="form-control" id="user_type" name="user_type">
                <option value="student">ছাত্র</option>
                <option value="teacher">শিক্ষক</option>
            </select><br>

            

            <label for="email">মেইল:</label>
            <input type="email" class="form-control" id="email" name="email" required><br>

            <label for="password">পাসওয়ার্ড:</label>
            <input type="password" class="form-control" id="password" name="password" required><br>

            <button type="submit" class="btn btn-primary">নিবন্ধন করুন</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer fixed-bottom text-center" style="background-color: black !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Social media links here 
                    <a href="https://www.facebook.com/arafat.rahman.1422409142240914" target="_blank" class="social-icon" style="width: 30px; height: 30px;">
                    <img src="facebook-logo.png" alt="Facebook Logo">
                    </a>
                    <a href="https://www.linkedin.com/in/yourlinkedinprofile" target="_blank" class="social-icon">
                    <img src="linkedin-logo.png" alt="LinkedIn Logo">
                    </a>
                    -->
                </div>
            </div>
        </div>
    </footer>

    <?php
        
        $servername = "localhost";
        $username = "root";  
        $password = "";      
        $dbname = "smartstudy"; 
        
        // Create a connection
        $conn = new mysqli($servername, $username, $password);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Check if the database exists, create if not
        $createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
        if ($conn->query($createDbQuery) === TRUE) {
            echo '<div class="alert alert-danger" role="alert">Database Already Exist ' .  '</div>';
        } else {
            echo '<div class="alert alert-success" role="alert">Database Created Successfully ' . $conn->error . "<br>";
        }
        
        $conn->select_db($dbname);
        
        // Check if the tables exist, create if not
        if (!tableExists($conn, 'Users') || !tableExists($conn, 'Courses') || !tableExists($conn, 'CoursesEnrollments') || !tableExists($conn, 'ExamsEnrollments') || !tableExists($conn, 'AssignmentsEnrollments') || !tableExists($conn, 'Assignments') || !tableExists($conn, 'Submissions') || !tableExists($conn, 'Grades') || !tableExists($conn, 'Instructors') || !tableExists($conn, 'Exams') || !tableExists($conn, 'ExamScores')) {
            include 'create_tb.php';
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_type = $_POST["user_type"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Check if the email already exists in the database
            $checkEmailQuery = "SELECT * FROM Users WHERE Email = '$email'";
            $result = $conn->query($checkEmailQuery);

            if ($result && $result->num_rows > 0) {
                // Email already exists, show a warning
                echo "<div class='alert alert-danger'>Email already exists. Please use a different email.</div>";
            } else {
                // Email is unique, proceed with registration
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash the password
                $insertUserQuery = "INSERT INTO Users (Username, Email, Password, UserType) VALUES ('$username', '$email', '$hashedPassword', '$user_type')";
                if ($conn->query($insertUserQuery) === TRUE) {
                    echo "<div class='alert alert-success'>Registration successful!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error during registration: " . $conn->error . "</div>";
                }
            }
        }

        function tableExists($conn, $tableName) {
            $result = $conn->query("SHOW TABLES LIKE '$tableName'");
            return $result && $result->num_rows > 0;
        }
    ?>
</body>
</html>