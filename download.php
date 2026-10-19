<?php require 'config.php'; need_student();
$s = $db->prepare("SELECT filename, original_name FROM notes WHERE id=?"); $s->bind_param('i', $_GET['id']); $s->execute();
$n = $s->get_result()->fetch_assoc(); $path = $n ? __DIR__.'/uploads/'.$n['filename'] : '';
if (!$n || !is_file($path)) { http_response_code(404); die('File not found.'); }
$db->query("UPDATE notes SET downloads=downloads+1 WHERE id=".(int)$_GET['id']);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.str_replace('"', '', basename($n['original_name'])).'"');
header('Content-Length: '.filesize($path)); readfile($path);
