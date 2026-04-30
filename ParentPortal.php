<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.html');
    exit;
}

if (($_SESSION['user_role'] ?? '') !== 'parent') {
    die('Access denied. Parent login required.');
}

$parentID = $_SESSION['parent_id'] ?? null;
if (!$parentID) {
    die('No parent profile linked to this account.');
}

$sql = "
SELECT
    s.student_id,
    s.studentID,
    s.first_name,
    s.last_name,
    s.gender,
    s.grade,
    s.address,
    s.email,
    s.phone,
    s.emergency_contact_name,
    s.emergency_contact_phone,
    s.emergency_contact_relationship,
    s.medical_notes,
    s.enrollment_status,
    sp.relationship
FROM StudentParents sp
JOIN students s ON (sp.studentID = s.studentID OR sp.studentID = s.student_id)
WHERE sp.parentID = ?
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Database error: ' . $conn->error);
}
$stmt->bind_param('i', $parentID);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Portal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 24px; }
        .wrap { max-width: 1000px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        h1 { margin-top: 0; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: top; }
        th { background: #f1f4f7; width: 240px; }
        .card { border: 1px solid #e5e9ed; border-radius: 8px; margin-top: 18px; overflow: hidden; }
        .card h2 { margin: 0; padding: 12px 14px; background: #ecf3fb; font-size: 18px; }
        .empty { margin-top: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Parent Portal</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>. Below is your linked student information.</p>

        <?php if ($result->num_rows === 0): ?>
            <p class="empty">No student is linked to this parent account yet.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <h2>
                        Student: <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                    </h2>
                    <table>
                        <tr><th>Relationship</th><td><?php echo htmlspecialchars($row['relationship'] ?? ''); ?></td></tr>
                        <tr><th>Student ID</th><td><?php echo htmlspecialchars($row['student_id']); ?></td></tr>
                        <tr><th>Gender</th><td><?php echo htmlspecialchars($row['gender'] ?? ''); ?></td></tr>
                        <tr><th>Grade</th><td><?php echo htmlspecialchars($row['grade'] ?? ''); ?></td></tr>
                        <tr><th>Enrollment Status</th><td><?php echo htmlspecialchars($row['enrollment_status'] ?? ''); ?></td></tr>
                        <tr><th>Address</th><td><?php echo htmlspecialchars($row['address'] ?? ''); ?></td></tr>
                        <tr><th>Email</th><td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td></tr>
                        <tr><th>Phone</th><td><?php echo htmlspecialchars($row['phone'] ?? ''); ?></td></tr>
                        <tr><th>Emergency Contact</th><td><?php echo htmlspecialchars($row['emergency_contact_name'] ?? ''); ?></td></tr>
                        <tr><th>Emergency Phone</th><td><?php echo htmlspecialchars($row['emergency_contact_phone'] ?? ''); ?></td></tr>
                        <tr><th>Emergency Relationship</th><td><?php echo htmlspecialchars($row['emergency_contact_relationship'] ?? ''); ?></td></tr>
                        <tr><th>Medical Notes</th><td><?php echo htmlspecialchars($row['medical_notes'] ?? ''); ?></td></tr>
                    </table>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>
</html>
