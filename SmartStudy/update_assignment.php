<?php
// Include your database connection code here if necessary

// Initialize variables
$assignmentID = $title = $description = $dueDate = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_assignment"])) {
    // Get the assignment ID and form data
    $assignmentID = $_POST["assignment_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $dueDate = $_POST["dueDate"];

    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "smartstudy";  // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement with placeholders
    $sql = "UPDATE Assignments SET Title = ?, Description = ?, DueDate = ? WHERE AssignmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $dueDate, $assignmentID);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Assignment updated successfully.";
    } else {
        echo "Error updating assignment: " . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} elseif (isset($_GET["id"])) {
    // If the assignment ID is provided in the URL, fetch the assignment data
    $assignmentID = $_GET["id"];

    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "smartstudy";  // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the assignment data from the database
    $sql = "SELECT Title, Description, DueDate FROM Assignments WHERE AssignmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $assignmentID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $title = $row["Title"];
            $description = $row["Description"];
            $dueDate = $row["DueDate"];
        } else {
            echo "Assignment not found.";
        }
    } else {
        echo "Error fetching assignment data: " . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid requests or direct access to this page
    echo "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Assignment</title>
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
            <!-- Logout Button -->
            <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Update Assignment</h1>
        <form method="POST" action="update_assignment.php">
            <div class="form-group">
                <label for="title">শিরোনাম:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
            </div>
            <div class="form-group">
                <label for="description">বর্ণনা:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="dueDate">নির্দিষ্ট তারিখ:</label>
                <input type="date" class="form-control" id="dueDate" name="dueDate" value="<?php echo $dueDate; ?>">
            </div>
            <input type="hidden" name="assignment_id" value="<?php echo $assignmentID; ?>">
            <button type="submit" name="update_assignment" class="btn btn-primary">আধুনিক করা</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
