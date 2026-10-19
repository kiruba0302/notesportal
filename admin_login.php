<?php require 'config.php'; $title = 'Admin login'; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = $db->prepare("SELECT id,username,password FROM admins WHERE username=?"); $s->bind_param('s', $_POST['username']); $s->execute();
    $a = $s->get_result()->fetch_assoc();
    if ($a && password_verify($_POST['password'], $a['password'])) { session_regenerate_id(true); $_SESSION['admin'] = $a['username']; header('Location: admin_dashboard.php'); exit; }
    $err = 'Username or password is incorrect.';
}
include 'auth_top.php'; ?>
<form class="card narrow" method="post"><h2>Admin login</h2>
<?php if ($err) echo '<p class="msg err">'.e($err).'</p>'; ?>
<label>Username<input name="username" required></label>
<label>Password<input type="password" name="password" required></label>
<button class="btn">Log in</button></form>
<?php include 'auth_bottom.php'; ?>
