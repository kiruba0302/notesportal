<?php require 'config.php'; $title = 'Register'; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']); $email = trim($_POST['email']); $pw = $_POST['password'];
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pw) < 6) $err = 'Enter your name, a valid email, and a password of at least 6 characters.';
    else {
        $s = $db->prepare("SELECT id FROM students WHERE email=?"); $s->bind_param('s', $email); $s->execute();
        if ($s->get_result()->num_rows) $err = 'This email is already registered. Log in instead.';
        else {
            $h = password_hash($pw, PASSWORD_DEFAULT);
            $s = $db->prepare("INSERT INTO students(name,email,password) VALUES(?,?,?)"); $s->bind_param('sss', $name, $email, $h); $s->execute();
            $_SESSION['student'] = ['id' => $db->insert_id, 'name' => $name]; header('Location: dashboard.php'); exit;
        }
    }
}
include 'auth_top.php'; ?>
<form class="card narrow" method="post"><h2>Create student account</h2>
<?php if ($err) echo '<p class="msg err">'.e($err).'</p>'; ?>
<label>Full name<input name="name" required></label>
<label>Email<input type="email" name="email" required></label>
<label>Password<input type="password" name="password" minlength="6" required></label>
<button class="btn">Register</button></form>
<?php include 'auth_bottom.php'; ?>
