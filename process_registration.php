<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Parent.html');
    exit;
}

$p_firstname = trim($_POST['p_firstname'] ?? '');
$p_lastname = trim($_POST['p_lastname'] ?? '');
$p_phone = trim($_POST['p_phone'] ?? '');
$p_address = trim($_POST['p_address'] ?? '');
$s_id = trim($_POST['s_id'] ?? '');
$s_relationship = trim($_POST['relationship'] ?? '');
$email = trim($_POST['p_email'] ?? '');
$password = $_POST['p_password'] ?? '';
$confirmPassword = $_POST['p_confirm_password'] ?? '';

if (!$p_firstname || !$p_lastname || !$p_phone || !$p_address || !$s_id || !$email || !$password || !$confirmPassword) {
    die('All required fields must be completed.');
}

if ($password !== $confirmPassword) {
    die('Passwords do not match. Please go back and try again.');
}

// Ensure the user email is unique.
$query = $conn->prepare('SELECT userID FROM Users WHERE email = ?');
$query->bind_param('s', $email);
$query->execute();
$query->store_result();
if ($query->num_rows > 0) {
    die('This email is already registered. Please login or use another email.');
}
$query->close();

// Verify that the student exists before linking.
$studentCheck = $conn->prepare('SELECT student_id FROM students WHERE student_id = ?');
$studentCheck->bind_param('i', $s_id);
$studentCheck->execute();
$studentCheck->store_result();
$studentExists = $studentCheck->num_rows > 0;
$studentCheck->close();

if (!$studentExists) {
    die('The student ID provided does not exist in the database.');
}

function getNextId($conn, $table, $column) {
    $stmt = $conn->prepare("SELECT COALESCE(MAX($column), 0) + 1 FROM $table");
    $stmt->execute();
    $stmt->bind_result($nextId);
    $stmt->fetch();
    $stmt->close();
    return $nextId;
}

$personID = getNextId($conn, 'Person', 'personID');
$parentID = getNextId($conn, 'Parents', 'parentID');
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$conn->begin_transaction();
try {
    $personInsert = $conn->prepare('INSERT INTO Person (personID, firstName, lastName, address, email) VALUES (?, ?, ?, ?, ?)');
    $personInsert->bind_param('issss', $personID, $p_firstname, $p_lastname, $p_address, $email);
    $personInsert->execute();
    $personInsert->close();

    $parentInsert = $conn->prepare('INSERT INTO Parents (parentID, personID, occupation, workNumber) VALUES (?, ?, ?, ?)');
    $occupation = 'Parent';
    $parentInsert->bind_param('iiss', $parentID, $personID, $occupation, $p_phone);
    $parentInsert->execute();
    $parentInsert->close();

    $studentParentInsert = $conn->prepare('INSERT INTO StudentParents (student_id, parentID, relationship) VALUES (?, ?, ?)');
    $studentParentInsert->bind_param('iis', $s_id, $parentID, $s_relationship);
    $studentParentInsert->execute();
    $studentParentInsert->close();

    $userInsert = $conn->prepare('INSERT INTO Users (email, passwordHash, role, parentID) VALUES (?, ?, ?, ?)');
    $role = 'parent';
    $userInsert->bind_param('sssi', $email, $passwordHash, $role, $parentID);
    $userInsert->execute();
    $userInsert->close();

    $conn->commit();
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = $role;
    $_SESSION['parent_id'] = $parentID;
    header('Location: Login.html?registered=1');
    exit;
} catch (Exception $e) {
    $conn->rollback();
    die('Registration failed: ' . $e->getMessage());
}
