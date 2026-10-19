<?php require 'config.php'; $title = 'Home';
$n = $db->query("SELECT COUNT(*) c FROM notes")->fetch_assoc()['c'];
include 'header.php'; ?>
<section class="hero">
 <h1>Share your class notes. Find everyone else's.</h1>
 <p><?= (int)$n ?> notes uploaded by students, sorted by subject and free to download.</p>
 <a class="btn" href="notes.php">Browse notes</a> <a class="btn alt" href="register.php">Create student account</a>
</section>
<?php include 'footer.php'; ?>
