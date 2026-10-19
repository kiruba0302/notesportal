<?php require 'config.php'; need_student(); $title = 'Available notes';
$subjects = $db->query("SELECT * FROM subjects ORDER BY name");
$sub = (int)($_GET['subject'] ?? 0); $q = '%'.trim($_GET['q'] ?? '').'%';
$s = $db->prepare("SELECT n.*, s.name subject, st.name author FROM notes n JOIN subjects s ON s.id=n.subject_id JOIN students st ON st.id=n.student_id
 WHERE (?=0 OR n.subject_id=?) AND n.title LIKE ? ORDER BY n.uploaded_at DESC");
$s->bind_param('iis', $sub, $sub, $q); $s->execute(); $rows = $s->get_result();
include 'header.php'; ?>
<h2>Available notes</h2>
<form class="filter" method="get"><input name="q" placeholder="Search by title" value="<?= e($_GET['q'] ?? '') ?>">
<select name="subject"><option value="0">All subjects</option>
<?php while ($x = $subjects->fetch_assoc()) echo '<option value="'.(int)$x['id'].'"'.($sub == $x['id'] ? ' selected' : '').'>'.e($x['name']).'</option>'; ?></select>
<button class="btn">Search</button></form>
<?php if (!$rows->num_rows) echo '<p class="hint">No notes match. Try another subject or upload some yourself.</p>'; ?>
<div class="grid"><?php while ($n = $rows->fetch_assoc()): ?>
<div class="card"><h3><?= e($n['title']) ?></h3><p class="hint"><?= e($n['subject']) ?> - by <?= e($n['author']) ?><br><?= (int)$n['downloads'] ?> downloads</p>
<a class="btn" href="download.php?id=<?= (int)$n['id'] ?>">Download</a></div>
<?php endwhile; ?></div>
<?php include 'footer.php'; ?>
