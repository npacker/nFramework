<!DOCTYPE html>
<html>
<head>
<title><?php echo $page_title; ?></title>
<link rel="stylesheet" href="http://localhost:8080/RecipeApp/RecipeApp/css/default.css" type="text/css" media="screen" />
</head>
<body>
<div id="envelope">
  <div id="head">
    <h1><a href="/index.php">Nigel Packer</a></h1>
  </div>
  <div id="body">
    <?php echo $page; ?>
  </div>
  <div id="foot">
    This website property of Nigel Packer &copy;<?php echo date('Y'); ?>
  </div>
</div>
</body>
</html>