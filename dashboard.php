<?php require 'config.php'; need_student(); $title = 'Dashboard'; $id = $_SESSION['student']['id'];
if (isset($_GET['delete'])) {
    $s = $db->prepare("SELECT filename FROM notes WHERE id=? AND student_id=?"); $s->bind_param('ii', $_GET['delete'], $id); $s->execute();
    if ($r = $s->get_result()->fetch_assoc()) {
        @unlink(_DIR_.'/uploads/'.$r['filename']);
        $d = $db->prepare("DELETE FROM notes WHERE id=? AND student_id=?"); $d->bind_param('ii', $_GET['delete'], $id); $d->execute();
    }
    header('Location: dashboard.php'); exit;
}
$total = $db->query("SELECT COUNT(*) c FROM notes")->fetch_assoc()['c'];
$s = $db->prepare("SELECT n.*, s.name subject FROM notes n JOIN subjects s ON s.id=n.subject_id WHERE student_id=? ORDER BY uploaded_at DESC");
$s->bind_param('i', $id); $s->execute(); $mine = $s->get_result();
include 'header.php'; ?>
<h2>Welcome, <?= e($_SESSION['student']['name']) ?></h2>
<div class="stats"><div class="card"><b><?= $mine->num_rows ?></b> your uploads</div><div class="card"><b><?= (int)$total ?></b> notes available</div></div>
<p><a class="btn" href="upload.php">Upload notes</a> <a class="btn alt" href="notes.php">Browse notes</a></p>
<h3>Your uploads</h3>
<?php if (!$mine->num_rows): ?><p class="hint">You have not uploaded anything yet. Upload your first notes to help classmates.</p>
<?php else: ?>
<div class="scroll"><table><tr><th>Title</th><th>Subject</th><th>Downloads</th><th>Date</th><th></th></tr>
<?php while ($n = $mine->fetch_assoc()): ?>
<tr><td><?= e($n['title']) ?></td><td><?= e($n['subject']) ?></td><td><?= (int)$n['downloads'] ?></td><td><?= e(substr($n['uploaded_at'],0,10)) ?></td>
<td><a class="danger" href="?delete=<?= (int)$n['id'] ?>" onclick="return confirm('Delete these notes?')">Delete</a></td></tr>
<?php endwhile; ?></table></div><?php endif; ?>
<?php include 'footer.php'; ?>