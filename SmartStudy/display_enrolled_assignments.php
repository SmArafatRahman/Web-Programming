<?php
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

    // Query to fetch enrolled assignments for the user
    $enrolledAssignmentsQuery = "SELECT Assignments.Title, Assignments.Description, Assignments.DueDate
                                FROM AssignmentsEnrollments
                                JOIN Assignments ON AssignmentsEnrollments.AssignmentID = Assignments.AssignmentID
                                WHERE AssignmentsEnrollments.UserID = $userID";

    $enrolledAssignmentsResult = $conn->query($enrolledAssignmentsQuery);
    
    // Display enrolled assignments in Bootstrap cards with glowing hover effect
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enrolled Assignments</title>
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
            <h2>Enrolled Assignments</h2>
            <div class="row">
                <?php while ($row = $enrolledAssignmentsResult->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["Title"]; ?></h5>
                                <p class="card-text"><?php echo $row["Description"]; ?></p>
                                <p class="card-text">Due Date: <?php echo $row["DueDate"]; ?></p>
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
