<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Login.html');
    exit;
}

$email = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    die('Please provide both email and password.');
}

$stmt = $conn->prepare('SELECT userID, passwordHash, role, parentID FROM Users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    die('Invalid login credentials.');
}

$stmt->bind_result($userID, $passwordHash, $role, $parentID);
$stmt->fetch();
$stmt->close();

if (!password_verify($password, $passwordHash)) {
    die('Invalid login credentials.');
}

$_SESSION['user_id'] = $userID;
$_SESSION['user_email'] = $email;
$_SESSION['user_role'] = $role;
$_SESSION['parent_id'] = $parentID;

header('Location: Homepage.html');
exit;
