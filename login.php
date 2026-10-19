<?php require 'config.php'; $title = 'Student login'; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = $db->prepare("SELECT id,name,password FROM students WHERE email=?"); $s->bind_param('s', $_POST['email']); $s->execute();
    $u = $s->get_result()->fetch_assoc();
    if ($u && password_verify($_POST['password'], $u['password'])) {
        session_regenerate_id(true); $_SESSION['student'] = ['id' => $u['id'], 'name' => $u['name']]; header('Location: dashboard.php'); exit;
    }
    $err = 'Email or password is incorrect.';
}
include 'auth_top.php'; ?>
<form class="card narrow" method="post"><h2>Student login</h2>
<?php if ($err) echo '<p class="msg err">'.e($err).'</p>'; ?>
<label>Email<input type="email" name="email" required></label>
<label>Password<input type="password" name="password" required></label>
<button class="btn">Log in</button><p class="hint">New here? <a href="register.php">Create an account</a></p></form>
<?php include 'auth_bottom.php'; ?>
