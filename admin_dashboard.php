<?php require 'config.php'; need_admin(); $title = 'Admin dashboard'; $err = '';
if (isset($_POST['subject'])) {
    $name = trim($_POST['subject']);
    if ($name !== '') { $s = $db->prepare("INSERT IGNORE INTO subjects(name) VALUES(?)"); $s->bind_param('s', $name); $s->execute(); }
    header('Location: admin_dashboard.php'); exit;
}
if (isset($_GET['delete_note'])) {
    $s = $db->prepare("SELECT filename FROM notes WHERE id=?"); $s->bind_param('i', $_GET['delete_note']); $s->execute();
    if ($r = $s->get_result()->fetch_assoc()) { @unlink(__DIR__.'/uploads/'.$r['filename']); $db->query("DELETE FROM notes WHERE id=".(int)$_GET['delete_note']); }
    header('Location: admin_dashboard.php'); exit;
}
if (isset($_GET['delete_student'])) { $db->query("DELETE FROM students WHERE id=".(int)$_GET['delete_student']); header('Location: admin_dashboard.php'); exit; }
$c = fn($t) => $db->query("SELECT COUNT(*) c FROM $t")->fetch_assoc()['c'];
$notes = $db->query("SELECT n.*, s.name subject, st.name author FROM notes n JOIN subjects s ON s.id=n.subject_id JOIN students st ON st.id=n.student_id ORDER BY n.uploaded_at DESC");
$students = $db->query("SELECT * FROM students ORDER BY created_at DESC");
$subjects = $db->query("SELECT * FROM subjects ORDER BY name");
include 'header.php'; ?>
<h2>Admin dashboard</h2>
<div class="stats"><div class="card"><b><?= $c('students') ?></b> students</div><div class="card"><b><?= $c('notes') ?></b> notes</div><div class="card"><b><?= $c('subjects') ?></b> subjects</div></div>
<h3>Subjects</h3>
<form class="filter" method="post"><input name="subject" placeholder="New subject name" required><button class="btn">Add subject</button></form>
<p><?php while ($s = $subjects->fetch_assoc()) echo '<span class="tag">'.e($s['name']).'</span>'; ?></p>
<h3>All notes</h3>
<div class="scroll"><table><tr><th>Title</th><th>Subject</th><th>Uploaded by</th><th>Downloads</th><th></th></tr>
<?php while ($n = $notes->fetch_assoc()): ?><tr><td><?= e($n['title']) ?></td><td><?= e($n['subject']) ?></td><td><?= e($n['author']) ?></td><td><?= (int)$n['downloads'] ?></td>
<td><a class="danger" href="?delete_note=<?= (int)$n['id'] ?>" onclick="return confirm('Delete this note?')">Delete</a></td></tr><?php endwhile; ?></table></div>
<h3>Students</h3>
<div class="scroll"><table><tr><th>Name</th><th>Email</th><th>Joined</th><th></th></tr>
<?php while ($s = $students->fetch_assoc()): ?><tr><td><?= e($s['name']) ?></td><td><?= e($s['email']) ?></td><td><?= e(substr($s['created_at'],0,10)) ?></td>
<td><a class="danger" href="?delete_student=<?= (int)$s['id'] ?>" onclick="return confirm('Delete this student and their notes records?')">Remove</a></td></tr><?php endwhile; ?></table></div>
<?php include 'footer.php'; ?>
