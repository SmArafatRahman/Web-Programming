<?php
// Include your database connection code here if necessary

// Initialize variables
$examID = $description = $examDate = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_exam"])) {
    // Get the exam ID and form data
    $examID = $_POST["exam_id"];
    $description = $_POST["description"];
    $examDate = $_POST["examDate"];

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
    $sql = "UPDATE Exams SET Description = ?, ExamDate = ? WHERE ExamID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $description, $examDate, $examID);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Exam updated successfully.";
    } else {
        echo "Error updating exam: " . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} elseif (isset($_GET["id"])) {
    // If the exam ID is provided in the URL, fetch the exam data
    $examID = $_GET["id"];

    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "smartstudy";  // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the exam data from the database
    $sql = "SELECT Description, ExamDate FROM Exams WHERE ExamID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $examID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $description = $row["Description"];
            $examDate = $row["ExamDate"];
        } else {
            echo "Exam not found.";
        }
    } else {
        echo "Error fetching exam data: " . $conn->error;
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
    <title>Update Exam</title>
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
        <h1>Update Exam</h1>
        <form method="POST" action="update_exam.php">
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>">
            </div>
            <div class="form-group">
                <label for="examDate">Exam Date:</label>
                <input type="date" class="form-control" id="examDate" name="examDate" value="<?php echo $examDate; ?>">
            </div>
            <input type="hidden" name="exam_id" value="<?php echo $examID; ?>">
            <button type="submit" name="update_exam" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
