<?php
require_once 'config.php';

$username = 'admin';
$plainPassword = 'admin123';
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $update->bind_param("ss", $hashedPassword, $username);
    $update->execute();
    echo "<h3>Na-update na ang password para sa 'admin'!</h3>";
} else {
    $insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
    $insert->bind_param("ss", $username, $hashedPassword);
    $insert->execute();
    echo "<h3>Matagumpay na nagawa ang Admin user!</h3>";
}

echo "<p>Maaari na kang mag-login gamit ang:</p>";
echo "<ul>";
echo "<li><b>Username:</b> admin</li>";
echo "<li><b>Password:</b> admin123</li>";
echo "</ul>";
echo '<br><a href="login.php">Pumunta sa Login Page</a>';
?>