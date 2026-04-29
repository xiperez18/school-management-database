<?php
include 'db.php';

$student_id = $_GET['id'] ?? null;

if (!$student_id) {
    die("No student ID provided.");
}

// Fetch student
$sql = "SELECT * FROM students WHERE student_id = $student_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();

// Backend-only output (for testing)
echo "=== STUDENT DATA ===<br>";
echo "ID: " . $student['student_id'] . "<br>";
echo "First Name: " . $student['first_name'] . "<br>";
echo "Last Name: " . $student['last_name'] . "<br>";
echo "Grade: " . $student['grade'] . "<br>";
echo "Email: " . $student['email'] . "<br>";

echo "<br><b>Ready to update via update_student.php</b>";
?>
