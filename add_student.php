<?php
require_once 'config.php';
include_once 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_no  = trim($_POST['student_number']);
    $first_name  = trim($_POST['first_name']);
    $middle_name = !empty(trim($_POST['middle_name'])) ? trim($_POST['middle_name']) : 'N/A';
    $last_name   = trim($_POST['last_name']);
    $email       = trim($_POST['email']);
    $course      = trim($_POST['course']);
    $year        = (int)$_POST['year_level'];

    if ($student_no && $first_name && $last_name && $email && $course && $year) {
        $stmt = $conn->prepare("INSERT INTO students (student_number, first_name, middle_name, last_name, email, course, year_level) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $student_no, $first_name, $middle_name, $last_name, $email, $course, $year);
        
        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Failed to add record: " . $stmt->error;
        }
    } else {
        $error = "All required fields must be filled.";
    }
}
?>

<div class="form-card">
    <h2>Add New Student</h2>
    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="add_student.php">
        <div class="form-group">
            <label>Student Number</label>
            <input type="text" name="student_number" required>
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" required>
        </div>
        <div class="form-group">
            <label>Middle Name <span style="font-weight: normal; color: #666;">(Optional, e.g., N/A)</span></label>
            <input type="text" name="middle_name" placeholder="N/A kung wala">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Course</label>
            <input type="text" name="course" placeholder="e.g., BSIT" required>
        </div>
        <div class="form-group">
            <label>Year Level</label>
            <select name="year_level" required>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
            </select>
        </div>
        <button type="submit" class="btn">Save Student</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include_once 'footer.php'; ?>