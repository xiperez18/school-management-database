<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // DEBUG: show what is being sent
    echo "<h3>DEBUG POST DATA:</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Get ID (must exist)
    $student_id = $_POST['student_id'] ?? null;

    if (!$student_id) {
        die("❌ ERROR: student_id is missing. Check your form hidden input.");
    }

    // Get fields safely
    $first = $_POST['first_name'] ?? '';
    $last = $_POST['last_name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $grade = $_POST['grade'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    // UPDATE QUERY
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

    // RUN QUERY
    if ($conn->query($sql)) {
        echo "<br>✔ Student updated successfully!";
    } else {
        echo "<br>❌ SQL Error: " . $conn->error;
    }

} else {
    echo "❌ Invalid request method.";
}
?>