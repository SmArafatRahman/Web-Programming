<?php
session_start();

if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "Teacher") {
    // Check if the user is a teacher

    if (isset($_POST["exam_id"])) {
        $examID = $_POST["exam_id"];

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

        // SQL query to delete the exam
        $sql = "DELETE FROM Exams WHERE ExamID = ?";

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $examID);

        if ($stmt->execute()) {
            // Exam deleted successfully
            header("Location: homepage.php"); // Redirect to the homepage or any other page
            exit();
        } else {
            // Error deleting exam
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Exam ID not provided.";
    }
} else {
    echo "You do not have permission to delete exams.";
}
?>
