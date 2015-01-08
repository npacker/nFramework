<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo strip_tags($title) ?> | Nigel Packer</title>
<meta charset="UTF-8">
<?php echo $style ?>
<?php echo $script ?>
</head>
<body>
  <div id="envelope">
    <div id="header">
      <h1><a href="<?php echo url() ?>">Nigel Packer</a></h1>
      <?php // echo $navigation; ?>
    </div>
    <div id="body">
      <h1><?php echo $title ?></h1>
      <?php echo $page ?>
    </div>
    <div id="footer">
      This website property of Nigel Packer &copy;2014
    </div>
  </div>
</body>
</html>
