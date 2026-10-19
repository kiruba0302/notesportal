<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'Notes Portal') ?> | Notes Portal</title>
<link rel="stylesheet" href="style.css"></head><body>
<header class="top"><a class="brand" href="index.php">Notes Portal</a>
<nav>
<?php if (!empty($_SESSION['student'])): ?>
 <a href="dashboard.php">Dashboard</a><a href="notes.php">Available notes</a><a href="upload.php">Upload notes</a><a href="logout.php">Log out</a>
<?php elseif (!empty($_SESSION['admin'])): ?>
 <a href="admin_dashboard.php">Admin dashboard</a><a href="logout.php">Log out</a>
<?php else: ?>
 <a href="login.php">Student login</a><a href="register.php">Register</a><a href="admin_login.php">Admin</a>
<?php endif; ?>
</nav></header><main>
