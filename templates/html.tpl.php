<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?> | Nigel Packer</title>
<meta charset="UTF-8">
<?php echo $style; ?>
<?php echo $script; ?>
</head>
<body>
	<div id="envelope">
		<div id="header">
    <?php echo $header; ?>
    </div>
		<div id="body">
			<h1><?php echo $page_title; ?></h1>
    <?php echo $page; ?>
    </div>
		<div id="footer">
    <?php echo $footer; ?>
    </div>
	</div>
</body>
</html>