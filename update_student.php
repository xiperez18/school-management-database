<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'] ?? null;

    if (!$student_id) {
        die("Student ID is missing.");
    }

    $first = $_POST['first_name'] ?? '';
    $last = $_POST['last_name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $grade = $_POST['grade'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $sql = "UPDATE students SET 
        first_name = '$first',
        last_name = '$last',
        gender = '$gender',
        grade = '$grade',
        address = '$address',
        email = '$email',
        phone = '$phone'
        WHERE student_id = $student_id
    ";

    if ($conn->query($sql)) {
        echo "<h3 style='color:green;'>Student updated successfully.</h3>";
        echo "<p><a href='Teacher.html'>Back to Teacher Portal</a></p>";
    } else {
        echo "<h3 style='color:red;'>Update failed: " . $conn->error . "</h3>";
    }

} else {
    echo "Invalid request method.";
}
?>