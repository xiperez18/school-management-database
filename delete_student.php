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
    echo "<h3 style='color:green;'>Student deleted successfully.</h3>";
    echo "<p><a href='Teacher.php' style='display:inline-block;padding:10px 14px;background:#3498db;color:#fff;text-decoration:none;border-radius:4px;'>Back to Teacher Portal</a></p>";
} else {
    echo "❌ Error deleting student: " . $conn->error;
}
?>