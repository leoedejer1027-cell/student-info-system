<?php
require_once 'config.php';
include_once 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    header("Location: dashboard.php");
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
        $updateStmt = $conn->prepare("UPDATE students SET student_number = ?, first_name = ?, middle_name = ?, last_name = ?, email = ?, course = ?, year_level = ? WHERE student_id = ?");
        $updateStmt->bind_param("ssssssii", $student_no, $first_name, $middle_name, $last_name, $email, $course, $year, $id);
        
        if ($updateStmt->execute()) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Update failed: " . $updateStmt->error;
        }
    } else {
        $error = "All required fields must be filled.";
    }
}
?>

<div class="form-card">
    <h2>Edit Student Record</h2>
    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_student.php?id=<?= $id ?>">
        <div class="form-group">
            <label>Student Number</label>
            <input type="text" name="student_number" value="<?= htmlspecialchars($student['student_number']) ?>" required>
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" value="<?= htmlspecialchars($student['middle_name']) ?>">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Course</label>
            <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
        </div>
        <div class="form-group">
            <label>Year Level</label>
            <select name="year_level" required>
                <option value="1" <?= $student['year_level'] == 1 ? 'selected' : '' ?>>1st Year</option>
                <option value="2" <?= $student['year_level'] == 2 ? 'selected' : '' ?>>2nd Year</option>
                <option value="3" <?= $student['year_level'] == 3 ? 'selected' : '' ?>>3rd Year</option>
                <option value="4" <?= $student['year_level'] == 4 ? 'selected' : '' ?>>4th Year</option>
            </select>
        </div>
        <button type="submit" class="btn">Update Student</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include_once 'footer.php'; ?>