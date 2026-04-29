<?php
include 'db.php';

// Get student ID (from URL or POST)
$student_id = $_GET['id'] ?? null;

if (!$student_id) {
    die("❌ No student ID provided.");
}

// DELETE query
$sql = "DELETE FROM students WHERE student_id = $student_id";

if ($conn->query($sql)) {
    echo "✔ Student deleted successfully!";
} else {
    echo "❌ Error deleting student: " . $conn->error;
}
?>