<?php
session_start();

// Check if the user is not logged in or not a teacher, then redirect
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "Teacher") {
    header("Location: homepage.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartstudy";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle form submission and add the exam to the database
    $courseID = $_POST["course_id"];
    $type = $_POST["type"];
    $description = $_POST["description"];
    $examDate = $_POST["exam_date"];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $insertQuery = "INSERT INTO Exams (CourseID, Type, Description, ExamDate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("isss", $courseID, $type, $description, $examDate);

    if ($stmt->execute()) {
        $successMessage = "Exam added successfully.";
    } else {
        $errorMessage = "Error adding the exam: " . $conn->error;
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
    <title>Add Exam - SmartStudy</title>
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
        <h1>পরীক্ষা যোগ করুন</h1>
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="course_id">কোর্স আইডি:</label>
                <input type="number" class="form-control" id="course_id" name="course_id" required>
            </div>
            <div class="form-group">
                <label for="type">প্রকার:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="Mid1">মধ্য মেয়াদী 1</option>
                    <option value="Mid2">মধ্য মেয়াদী 2</option>
                    <option value="Final">চূড়ান্ত পরীক্ষা</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">বর্ণনা:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="exam_date">পরীক্ষার তারিখ:</label>
                <input type="date" class="form-control" id="exam_date" name="exam_date" required>
            </div>
            <button type="submit" class="btn btn-primary">পরীক্ষা যোগ করুন</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
