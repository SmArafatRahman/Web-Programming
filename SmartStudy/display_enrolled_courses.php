<?php
// Start the session
session_start();

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

if (isset($_SESSION["user_id"])) {
    $userID = $_SESSION["user_id"];

    // Query to fetch enrolled courses for the user
    $enrolledCoursesQuery = "SELECT Courses.CourseName, Courses.Description
                             FROM CoursesEnrollments
                             JOIN Courses ON CoursesEnrollments.CourseID = Courses.CourseID
                             WHERE CoursesEnrollments.UserID = ?";

    // Use a prepared statement to avoid SQL injection
    if ($stmt = $conn->prepare($enrolledCoursesQuery)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $enrolledCoursesResult = $stmt->get_result();
        $stmt->close();
    } else {
        // Handle the SQL error here
        die("Error in prepared statement: " . $conn->error);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enrolled Courses</title>
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .card:hover {
                box-shadow: 0 0 20px rgba(255, 0, 0, 0.6); /* Change the color here (rgba) */
                transition: box-shadow 0.3s ease-in-out;
            }
        </style>
    </head>
    <body>
        <div class="container mt-4">
            <h2>Enrolled Courses</h2>
            <div class="row">
                <?php while ($row = $enrolledCoursesResult->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["CourseName"]; ?></h5>
                                <p class="card-text"><?php echo $row["Description"]; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Include Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    echo "Invalid request.";
}

$conn->close();
?>
