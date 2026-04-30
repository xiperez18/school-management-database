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
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Search Results</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 24px; }
        .wrap { max-width: 980px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f1f4f7; }
    </style>
</head>
<body>
    <div class="wrap">
        <p><a href="searchStudent.html">← Back to search</a></p>
        <h1>Students</h1>
        <?php if ($search !== ''): ?>
            <p>Showing results for: <strong><?php echo htmlspecialchars($search); ?></strong></p>
        <?php else: ?>
            <p>Showing all students.</p>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Grade</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['grade']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No students found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>