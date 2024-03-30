<?php
session_start();

if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "Teacher") {
    // Check if the user is a teacher

    if (isset($_POST["course_id"])) {
        $courseID = $_POST["course_id"];

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
            // Step 1: Delete records from assignments table
            $sql_delete_assignments = "DELETE FROM assignments WHERE CourseID = ?";
            $stmt_delete_assignments = $conn->prepare($sql_delete_assignments);
            $stmt_delete_assignments->bind_param("i", $courseID);

            if (!$stmt_delete_assignments->execute()) {
                throw new Exception("Error deleting course assignments.");
            }

            // Step 2: Delete the course
            $sql_delete_course = "DELETE FROM Courses WHERE CourseID = ?";
            $stmt_delete_course = $conn->prepare($sql_delete_course);
            $stmt_delete_course->bind_param("i", $courseID);

            if (!$stmt_delete_course->execute()) {
                throw new Exception("Error deleting course.");
            }

            // Commit the transaction
            $conn->commit();

            // Course deleted successfully
            header("Location: homepage.php"); // Redirect to the homepage or any other page
            exit();
        } catch (Exception $e) {
            // Rollback the transaction and handle the error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }

        $stmt_delete_assignments->close();
        $stmt_delete_course->close();
        $conn->close();
    } else {
        echo "Course ID not provided.";
    }
} else {
    echo "You do not have permission to delete courses.";
}
?>
