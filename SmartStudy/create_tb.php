<?php
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

// SQL queries to create tables for SmartStudy
$queries = [
    "CREATE TABLE IF NOT EXISTS Users (
        UserID INT PRIMARY KEY AUTO_INCREMENT,
        Username VARCHAR(50) NOT NULL,
        Password VARCHAR(255) NOT NULL,
        Email VARCHAR(100) NOT NULL,
        UserType ENUM('Student', 'Teacher') NOT NULL
    )",

    "CREATE TABLE IF NOT EXISTS Courses (
        CourseID INT PRIMARY KEY AUTO_INCREMENT,
        CourseName VARCHAR(255) NOT NULL,
        Description TEXT,
        InstructorID INT,
        StartDate DATE,
        EndDate DATE,
        FOREIGN KEY (InstructorID) REFERENCES Users(UserID)
    )",

    "CREATE TABLE IF NOT EXISTS CoursesEnrollments (
        EnrollmentID INT PRIMARY KEY AUTO_INCREMENT,
        UserID INT,
        CourseID INT,
        EnrollmentDate DATE,
        FOREIGN KEY (UserID) REFERENCES Users(UserID),
        FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
    )",
    "CREATE TABLE IF NOT EXISTS Exams (
        ExamID INT PRIMARY KEY AUTO_INCREMENT,
        CourseID INT,
        Type ENUM('Mid1', 'Mid2', 'Final') NOT NULL,
        Description TEXT,
        ExamDate DATE,
        FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
    )",

    "CREATE TABLE IF NOT EXISTS Assignments (
        AssignmentID INT PRIMARY KEY AUTO_INCREMENT,
        CourseID INT,
        Title VARCHAR(255) NOT NULL,
        Description TEXT,
        DueDate DATE,
        FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
    )",

    "CREATE TABLE IF NOT EXISTS Submissions (
        SubmissionID INT PRIMARY KEY AUTO_INCREMENT,
        AssignmentID INT,
        UserID INT,
        SubmissionDate DATETIME,
        FileURL VARCHAR(255),
        FOREIGN KEY (AssignmentID) REFERENCES Assignments(AssignmentID),
        FOREIGN KEY (UserID) REFERENCES Users(UserID)
    )",

    "CREATE TABLE IF NOT EXISTS Grades (
        GradeID INT PRIMARY KEY AUTO_INCREMENT,
        AssignmentID INT,
        UserID INT,
        Score DECIMAL(5, 2),
        Feedback TEXT,
        FOREIGN KEY (AssignmentID) REFERENCES Assignments(AssignmentID),
        FOREIGN KEY (UserID) REFERENCES Users(UserID)
    )",

    "CREATE TABLE IF NOT EXISTS Instructors (
        InstructorID INT PRIMARY KEY AUTO_INCREMENT,
        UserID INT,
        FOREIGN KEY (UserID) REFERENCES Users(UserID)
    )",

    "CREATE TABLE IF NOT EXISTS ExamsEnrollments (
        EnrollmentID INT PRIMARY KEY AUTO_INCREMENT,
        UserID INT,
        ExamID INT,  -- Correctly references ExamID
        EnrollmentDate DATE,
        FOREIGN KEY (UserID) REFERENCES Users(UserID),
        FOREIGN KEY (ExamID) REFERENCES Exams(ExamID)  -- Correctly references ExamID
    )",
    "CREATE TABLE IF NOT EXISTS AssignmentsEnrollments (
        EnrollmentID INT PRIMARY KEY AUTO_INCREMENT,
        UserID INT,
        AssignmentID INT,
        EnrollmentDate DATE,
        FOREIGN KEY (UserID) REFERENCES Users(UserID),
        FOREIGN KEY (AssignmentID) REFERENCES Assignments(AssignmentID)
    )",

    "CREATE TABLE IF NOT EXISTS ExamScores (
        ExamScoreID INT PRIMARY KEY AUTO_INCREMENT,
        ExamID INT,
        UserID INT,
        Score DECIMAL(5, 2),
        Feedback TEXT,
        FOREIGN KEY (ExamID) REFERENCES Exams(ExamID),  -- Reference to Exams table
        FOREIGN KEY (UserID) REFERENCES Users(UserID)
    )"
];

// Execute each query
foreach ($queries as $query) {
    if ($conn->query($query) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }
}

echo "Tables created successfully";

$conn->close();
?>
