<?php
require_once 'config.php';
include_once 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM students ORDER BY created_at DESC");
$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
?>

<div class="table-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h2>Student Directory</h2>
        <!-- Nilagyan ng class="no-print" para hindi sumama sa print preview -->
        <div class="no-print">
            <button onclick="window.print()" class="btn" style="background-color: #0d9488; margin-right: 5px;">🖨️ Print List</button>
            <a href="add_student.php" class="btn">+ Add Student</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student #</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['student_number']) ?></td>
                    <td>
                        <?= htmlspecialchars($s['first_name'] . ' ' . (!empty($s['middle_name']) && $s['middle_name'] !== 'N/A' ? $s['middle_name'] . ' ' : '') . $s['last_name']) ?>
                    </td>
                    <td><?= htmlspecialchars($s['email']) ?></td>
                    <td><?= htmlspecialchars($s['course']) ?></td>
                    <td><?= htmlspecialchars($s['year_level']) ?></td>
                    <td>
                        <a href="edit_student.php?id=<?= $s['student_id'] ?>" class="btn" style="padding: 4px 8px; font-size: 0.85rem;">Edit</a>
                        <button onclick="confirmDelete(<?= $s['student_id'] ?>)" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.85rem;">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include_once 'footer.php'; ?>