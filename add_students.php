<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first = $_POST['first_name'] ?? '';
    $last = $_POST['last_name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $grade = $_POST['grade'] ?? '';
    $address = $_POST['address'] ?? '';

    $emergency_name = $_POST['emergency_contact_name'] ?? '';
    $emergency_phone = $_POST['emergency_contact_phone'] ?? '';
    $emergency_rel = $_POST['emergency_contact_relationship'] ?? '';

    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $medical = $_POST['medical_notes'] ?? '';

    $sql = "INSERT INTO students (
        first_name,
        last_name,
        gender,
        grade,
        address,
        emergency_contact_name,
        emergency_contact_phone,
        emergency_contact_relationship,
        email,
        phone,
        medical_notes
    ) VALUES (
        '$first',
        '$last',
        '$gender',
        '$grade',
        '$address',
        '$emergency_name',
        '$emergency_phone',
        '$emergency_rel',
        '$email',
        '$phone',
        '$medical'
    )";

    if ($conn->query($sql)) {
        echo "<h3 style='color:green;'>✔ Student added successfully!</h3>";
    } else {
        echo "<h3 style='color:red;'>❌ Error: " . $conn->error . "</h3>";
    }
}
?>