<?php
session_start();

if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "Teacher") {
    // Check if the user is a teacher

    if (isset($_POST["course_id"]) && isset($_POST["assignment_id"])) {
        $courseID = $_POST["course_id"];
        $assignmentID = $_POST["assignment_id"];

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

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Step 1: Delete records from submissions table
            $sql_delete_submissions = "DELETE FROM submissions WHERE AssignmentID = ?";
            $stmt_delete_submissions = $conn->prepare($sql_delete_submissions);
            $stmt_delete_submissions->bind_param("i", $assignmentID);

            if (!$stmt_delete_submissions->execute()) {
                throw new Exception("Error deleting assignment submissions.");
            }

            // Step 2: Delete the assignment
            $sql_delete_assignment = "DELETE FROM assignments WHERE AssignmentID = ? AND CourseID = ?";
            $stmt_delete_assignment = $conn->prepare($sql_delete_assignment);
            $stmt_delete_assignment->bind_param("ii", $assignmentID, $courseID);

            if (!$stmt_delete_assignment->execute()) {
                throw new Exception("Error deleting assignment.");
            }

            // Commit the transaction
            $conn->commit();

            // Assignment deleted successfully
            header("Location: homepage.php"); // Redirect to the homepage or any other page
            exit();
        } catch (Exception $e) {
            // Rollback the transaction and handle the error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }

        // Close prepared statements and the connection
        $stmt_delete_submissions->close();
        $stmt_delete_assignment->close();
        $conn->close();
    } else {
        echo "Course ID or Assignment ID not provided.";
    }
} else {
    echo "You do not have permission to delete assignments.";
}
?>
