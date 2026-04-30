<?php
include 'db.php';

$student_id = $_GET['id'] ?? null;

if (!$student_id) {
    die("No student ID provided.");
}

// Fetch student
$sql = "SELECT * FROM students WHERE student_id = $student_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 24px; }
        .wrap { max-width: 680px; margin: 0 auto; background: #fff; padding: 28px; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        label { display: block; font-weight: bold; margin: 10px 0 6px; }
        input, select { width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 18px; padding: 10px 18px; background: #f39c12; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #d68910; }
    </style>
</head>
<body>
    <div class="wrap">
        <p><a href="editStudent.html">← Back to student lookup</a></p>
        <h1>Edit Student #<?php echo htmlspecialchars($student['student_id']); ?></h1>

        <form method="post" action="update_student.php">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>">

            <label for="first_name">First name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>

            <label for="last_name">Last name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>

            <label for="gender">Gender</label>
            <select id="gender" name="gender">
                <option value="Male" <?php echo $student['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $student['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo $student['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>

            <label for="grade">Grade</label>
            <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($student['grade']); ?>">

            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($student['address']); ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>">

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>">

            <button type="submit">Save changes</button>
        </form>
    </div>
</body>
</html>
