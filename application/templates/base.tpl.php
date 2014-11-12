<!DOCTYPE html>
<html>
<head>
<title><?php echo strip_tags($title) ?></title>
<meta charset="UTF-8">
<?php echo $style ?>
<?php echo $script ?>
</head>
<body class="message <?php if (isset($level)): echo $level; endif ?>">
<div class="page">
  <header>
    <h1>nFramework</h1>
  </header>
  <section class="content">
    <h2><?php echo $title ?></h2>
    <article>
    <?php echo $content ?>
    </article>
  </section>
</div>
</body>
</html>
