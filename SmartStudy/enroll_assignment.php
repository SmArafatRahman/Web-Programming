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

if (isset($_SESSION["user_id"]) && isset($_POST["assignment_id"])) {
    $userID = $_SESSION["user_id"];
    $assignmentID = $_POST["assignment_id"];

    // Check if the user is already enrolled in the assignment
    $checkEnrollmentQuery = "SELECT * FROM AssignmentsEnrollments WHERE UserID = $userID AND AssignmentID = $assignmentID";
    $enrollmentResult = $conn->query($checkEnrollmentQuery);

    if ($enrollmentResult && $enrollmentResult->num_rows > 0) {
        echo "You are already enrolled in this assignment.";
    } else {
        // Enroll the user in the assignment
        $enrollQuery = "INSERT INTO AssignmentsEnrollments (UserID, AssignmentID, EnrollmentDate) VALUES ($userID, $assignmentID, NOW())";

        if ($conn->query($enrollQuery) === TRUE) {
            echo "Enrollment in the assignment successful!";
        } else {
            echo "Error enrolling in the assignment: " . $conn->error;
        }
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
