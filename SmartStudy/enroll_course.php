<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartstudy";  // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION["user_id"]) && isset($_POST["course_id"])) {
    $userID = $_SESSION["user_id"];
    $courseID = $_POST["course_id"];

    // Check if the user is already enrolled in the course
    $checkEnrollmentQuery = "SELECT * FROM CoursesEnrollments WHERE UserID = $userID AND CourseID = $courseID";
    $enrollmentResult = $conn->query($checkEnrollmentQuery);

    if ($enrollmentResult && $enrollmentResult->num_rows > 0) {
        echo "You are already enrolled in this course.";
    } else {
        // Enroll the user in the course
        $enrollQuery = "INSERT INTO CoursesEnrollments (UserID, CourseID, EnrollmentDate) VALUES ($userID, $courseID, NOW())";

        if ($conn->query($enrollQuery) === TRUE) {
            echo "Enrollment in the course successful!";
        } else {
            echo "Error enrolling in the course: " . $conn->error;
        }
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
