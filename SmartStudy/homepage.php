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

// Function to check if the user is a teacher
function isTeacher() {
    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "Teacher") {
        return true;
    }
    return false;
}

// Query to fetch courses
$coursesQuery = "SELECT * FROM Courses";
$coursesResult = $conn->query($coursesQuery);

// Query to fetch exams
$examsQuery = "SELECT * FROM Exams";
$examsResult = $conn->query($examsQuery);

// Query to fetch assignments
$assignmentsQuery = "SELECT * FROM Assignments";
$assignmentsResult = $conn->query($assignmentsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - SmartStudy</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .scrollable-container {
            overflow-x: auto;
            white-space: nowrap;
        }
        .card {
            display: inline-block;
            width: 300px; /* Adjust card width as needed */
            margin-right: 10px; /* Adjust margin as needed */
        }
        .card:hover {
                box-shadow: 0 0 20px rgba(255, 0, 0, 0.6); /* Change the color here (rgba) */
                transition: box-shadow 0.3s ease-in-out;
            }

    </style>
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
            <ul class="navbar-nav ml-auto">
                <?php if (isTeacher()): ?>
                    <!-- Add Course Button -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="add_course.php">Add Course</a>
                    </li>
                    <!-- Add Exam Button -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="add_exam.php">Add Exam</a>
                    </li>
                    <!-- Add Assignment Button -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="add_assignment.php">Add Assignment</a>
                    </li>
                <?php else: ?>
                    <!-- Display Enrolled Courses Button -->
                    <li class="nav-item">
                        <a class="btn btn-success" href="display_enrolled_courses.php">Enrolled Courses</a>
                    </li>
                    <!-- Display Enrolled Exams Button -->
                    <li class="nav-item">
                        <a class="btn btn-success" href="display_enrolled_exams.php">Enrolled Exams</a>
                    </li>
                    <!-- Display Enrolled Assignments Button -->
                    <li class="nav-item">
                        <a class="btn btn-success" href="display_enrolled_assignments.php">Enrolled Assignments</a>
                    </li>
                <?php endif; ?>
                <!-- Logout Button -->
                <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container mt-4">
        <h1>Welcome to SmartStudy</h1>
        
        <!-- Courses Cards -->
        <h2>Courses</h2>
        <div class="scrollable-container">
            <?php while ($course = $coursesResult->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $course["CourseName"]; ?></h5>
                        <form action="enroll_course.php" method="POST"> <!-- Use enroll_course.php -->
                            <input type="hidden" name="course_id" value="<?php echo $course["CourseID"]; ?>">
                            <button type="submit" name="enroll" class="btn btn-primary">Enroll</button>
                        </form>
                        <?php if (isTeacher()): ?>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <!-- Update Button -->
                                <form action="update_course.php" method="POST">
                                    <input type="hidden" name="course_id" value="<?php echo $course["CourseID"]; ?>">
                                    <button type="submit" name="update" class="btn btn-warning mr-2">Update</button>
                                </form>
                                <!-- Delete Button -->
                                <form action="delete_course.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    <input type="hidden" name="course_id" value="<?php echo $course["CourseID"]; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>



        <!-- Exams Cards -->
        <h2>Exams</h2>
        <div class="scrollable-container">
            <?php while ($exam = $examsResult->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $exam["Description"]; ?></h5>
                        <form action="enroll_exam.php" method="POST"> <!-- Use enroll_exam.php -->
                            <input type="hidden" name="exam_id" value="<?php echo $exam["ExamID"]; ?>">
                            <button type="submit" name="enroll" class="btn btn-primary">Enroll</button>
                        </form>
                        <?php if (isTeacher()): ?>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <!-- Update Button -->
                                <form action="update_exam.php" method="POST">
                                    <input type="hidden" name="exam_id" value="<?php echo $exam["ExamID"]; ?>">
                                    <button type="submit" name="update" class="btn btn-warning mr-2">Update</button>
                                </form>
                                <!-- Delete Button -->
                                <form action="delete_exam.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this exam?');">
                                    <input type="hidden" name="exam_id" value="<?php echo $exam["ExamID"]; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>



        <!-- Assignments Cards -->
        <h2>Assignments</h2>
        <div class="scrollable-container">
            <?php while ($assignment = $assignmentsResult->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $assignment["Title"]; ?></h5>
                        <form action="enroll_assignment.php" method="POST"> <!-- Use enroll_assignment.php -->
                            <input type="hidden" name="assignment_id" value="<?php echo $assignment["AssignmentID"]; ?>">
                            <button type="submit" name="enroll" class="btn btn-primary">Enroll</button>
                        </form>
                        <?php if (isTeacher()): ?>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <!-- Update Button -->
                                <form action="update_assignment.php" method="POST">
                                    <input type="hidden" name="course_id" value="<?php echo $course["CourseID"]; ?>">
                                    <input type="hidden" name="assignment_id" value="<?php echo $assignment["AssignmentID"]; ?>">
                                    <button type="submit" name="update" class="btn btn-warning mr-2">Update</button>
                                </form>
                                <!-- Delete Button -->
                                <form action="delete_assignment.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                                    <!-- Pass both course_id and assignment_id -->
                                    <input type="hidden" name="course_id" value="<?php echo $course["CourseID"]; ?>">
                                    <input type="hidden" name="assignment_id" value="<?php echo $assignment["AssignmentID"]; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
