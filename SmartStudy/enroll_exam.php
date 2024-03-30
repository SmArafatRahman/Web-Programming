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

if (isset($_SESSION["user_id"]) && isset($_POST["exam_id"])) {
    $userID = $_SESSION["user_id"];
    $examID = $_POST["exam_id"];

    // Check if the user is already enrolled in the exam
    $checkEnrollmentQuery = "SELECT * FROM ExamsEnrollments WHERE UserID = $userID AND ExamID = $examID";
    $enrollmentResult = $conn->query($checkEnrollmentQuery);

    if ($enrollmentResult && $enrollmentResult->num_rows > 0) {
        echo "You are already enrolled in this exam.";
    } else {
        // Enroll the user in the exam
        $enrollQuery = "INSERT INTO ExamsEnrollments (UserID, ExamID, EnrollmentDate) VALUES ($userID, $examID, NOW())";

        if ($conn->query($enrollQuery) === TRUE) {
            echo "Enrollment in the exam successful!";
        } else {
            echo "Error enrolling in the exam: " . $conn->error;
        }
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
