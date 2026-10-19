<?php require 'config.php'; need_student(); $title = 'Upload notes'; $msg = ''; $err = '';
$subjects = $db->query("SELECT * FROM subjects ORDER BY name");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'txt'];
    $f = $_FILES['file'] ?? null; $t = trim($_POST['title']); $sub = (int)$_POST['subject'];
    $ext = $f ? strtolower(pathinfo($f['name'], PATHINFO_EXTENSION)) : '';
    if ($t === '' || !$sub) $err = 'Enter a title and choose a subject.';
    elseif (!$f || $f['error'] !== UPLOAD_ERR_OK) $err = 'Choose a file to upload (max 10 MB).';
    elseif (!in_array($ext, $allowed)) $err = 'Only PDF, DOC, DOCX, PPT, PPTX or TXT files are allowed.';
    elseif ($f['size'] > 10 * 1024 * 1024) $err = 'File is larger than 10 MB.';
    else {
        $stored = bin2hex(random_bytes(12)).'.'.$ext;
        if (move_uploaded_file($f['tmp_name'], __DIR__.'/uploads/'.$stored)) {
            $s = $db->prepare("INSERT INTO notes(subject_id,student_id,title,filename,original_name) VALUES(?,?,?,?,?)");
            $s->bind_param('iisss', $sub, $_SESSION['student']['id'], $t, $stored, $f['name']); $s->execute();
            $msg = 'Notes uploaded.';
        } else $err = 'Upload failed. Check that the uploads folder is writable.';
    }
}
include 'header.php'; ?>
<form class="card narrow" method="post" enctype="multipart/form-data"><h2>Upload notes</h2>
<?php if ($msg) echo '<p class="msg ok">'.e($msg).'</p>'; if ($err) echo '<p class="msg err">'.e($err).'</p>'; ?>
<label>Title<input name="title" required></label>
<label>Subject<select name="subject" required><option value="">Choose subject</option>
<?php while ($s = $subjects->fetch_assoc()) echo '<option value="'.(int)$s['id'].'">'.e($s['name']).'</option>'; ?></select></label>
<label>File (PDF, DOC, DOCX, PPT, PPTX, TXT; max 10 MB)<input type="file" name="file" required></label>
<button class="btn">Upload notes</button></form>
<?php include 'footer.php'; ?>
