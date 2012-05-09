<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo $page_title ? $page_title.' - ' : '' ?>Kottu</title>
	<link rel="stylesheet" type="text/css" href="static/style.css" />
</head>

<body>
<ul>
<?php foreach($this->$item as $i): ?>
	<li><?php echo $i; ?></li>
<?php endforeach ?>
</ul>
</body>
</html>
