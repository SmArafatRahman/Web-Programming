<?php
session_start();

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Teacher") {
    header("Location: homepage.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartstudy";  // Replace with your database name

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle form submission and add the course to the database
    $courseName = $_POST["course_name"];
    $description = $_POST["description"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $insertQuery = "INSERT INTO Courses (CourseName, Description, StartDate, EndDate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $courseName, $description, $startDate, $endDate);

    if ($stmt->execute()) {
        $successMessage = "Course added successfully.";
    } else {
        $errorMessage = "Error adding the course: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course - SmartStudy</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">SmartStudy</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="homepage.php">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if ($_SESSION["user_type"] === "Teacher"): ?>
                    <!-- Add Course Button -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="add_course.php">কোর্স যোগ করুন</a>
                    </li>
                    <!-- Add Exam Button -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="add_exam.php">পরীক্ষা যোগ করুন</a>
                    </li>
                    <!-- Add Assignment Button -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="add_assignment.php">অ্যাসাইনমেন্ট যোগ করুন</a>
                    </li>
                <?php endif; ?>
                <!-- Logout Button -->
                <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">প্রস্থান</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>কোর্স যোগ করুন</h1>
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">Logo
                <label for="course_name">কোর্স নাম:</label>
                <input type="text" class="form-control" id="course_name" name="course_name" required>
            </div>
            <div class="form-group">
                <label for="description">বর্ণনা:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">শুরুর তারিখ</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">শেষ তারিখ</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="btn btn-primary">
কোর্স যোগ করুন</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
