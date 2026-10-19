<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'Notes Portal') ?> | Notes Portal</title>
<link rel="stylesheet" href="style.css"><link rel="stylesheet" href="auth3d.css"></head>
<body class="auth">
<div class="scene" aria-hidden="true">
 <div class="logo3d"><div class="spin">
<?php for ($i = 11; $i >= 0; $i--): ?><div class="layer<?= $i == 0 ? ' front' : '' ?>" style="transform:translateZ(<?= -$i * 3 ?>px)"><b>AVS</b><span>College of Arts and Science</span><em>(Autonomous)</em></div>
<?php endfor; ?>
</div></div>
 <i class="page p1"></i><i class="page p2"></i><i class="page p3"></i>
</div>
<div class="stage"><a class="brand" href="index.php">Notes Portal</a>
<div class="tilt" id="tilt">
