<?php
include 'db.php';

// Get search input (if any)
$search = $_GET['search'] ?? '';

// Base SQL query
$sql = "SELECT * FROM students";

// Add search filter if needed
if (!empty($search)) {
    $sql .= " WHERE first_name LIKE '%$search%' 
              OR last_name LIKE '%$search%' 
              OR student_id LIKE '%$search%'";
}

$result = $conn->query($sql);

// Check if query worked
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Output results (no HTML page, just data)
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        echo "ID: " . $row['student_id'] . "\n";
        echo "Name: " . $row['first_name'] . " " . $row['last_name'] . "\n";
        echo "Gender: " . $row['gender'] . "\n";
        echo "Grade: " . $row['grade'] . "\n";
        echo "Email: " . $row['email'] . "\n";
        echo "Phone: " . $row['phone'] . "\n";
        echo "----------------------\n";
    }

} else {
    echo "No students found.";
}
?>