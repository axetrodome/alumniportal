<?php
require_once '../core/init.php';
$jobs = true;
$partner = new Partner();
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once '../functions/header.php'; ?>
</head>
<body>
	<?php require_once '../functions/navigationbar.php'; ?>
	<?= $partner->data()->email; ?>
</body>
</html>