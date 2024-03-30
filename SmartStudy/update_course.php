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

$courseID = $courseName = $description = "";
$successMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_course"])) {
    $courseID = $_POST["course_id"]; // Ensure "course_id" is included in the form
    $courseName = $_POST["courseName"];
    $description = $_POST["description"];
    
    // Prepare and bind the SQL statement with placeholders
    $sql = "UPDATE Courses SET CourseName = ?, Description = ? WHERE CourseID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $courseName, $description, $courseID);

    // Execute the prepared statement
    if ($stmt->execute()) {
        $successMessage = "Course updated successfully.";
    } else {
        $errorMessage = "Error updating course: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Fetch course data for the form
$sql = "SELECT CourseName, Description FROM Courses WHERE CourseID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $courseID);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $courseName = $row["CourseName"];
        $description = $row["Description"];
    } else {
        $errorMessage = "Course not found.";
    }
} else {
    $errorMessage = "Error fetching course data: " . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Update Course</h1>
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="update_course.php">
            <input type="hidden" name="course_id" value="<?php echo $courseID; ?>">
            <div class="form-group">
                <label for="courseName">Course Name:</label>
                <input type="text" class="form-control" id="courseName" name="courseName" value="<?php echo $courseName; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
            </div>
            <button type="submit" name="update_course" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
