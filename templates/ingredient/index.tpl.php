<ol>
<?php foreach ($ingredients as $ingredient): ?>
<?php extract($ingredient); ?>
  <li><?php echo $title; ?> <strong>(<?php echo $quantity; ?>)</strong></li>
<?php endforeach; ?>
</ol>
