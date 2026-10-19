<?php
session_start();
$db = @new mysqli('localhost', 'root', '', 'notes_portal');
if ($db->connect_error) die('Database connection failed. Start MySQL in XAMPP and import database.sql.');
$db->set_charset('utf8mb4');
// First run: create default admin (username: admin, password: admin123). Change it after login.
if ($db->query("SELECT COUNT(*) c FROM admins")->fetch_assoc()['c'] == 0) {
    $h = password_hash('admin123', PASSWORD_DEFAULT);
    $s = $db->prepare("INSERT INTO admins(username,password) VALUES('admin',?)");
    $s->bind_param('s', $h); $s->execute();
}
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function need_student() { if (empty($_SESSION['student'])) { header('Location: login.php'); exit; } }
function need_admin() { if (empty($_SESSION['admin'])) { header('Location: admin_login.php'); exit; } }
