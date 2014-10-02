<ol>
<?php foreach ($ingredients as $ingredient): ?>
  <li><?php echo $ingredient['title']; ?> <strong>(<?php echo $ingredient['quantity']; ?>)</strong></li>
<?php endforeach; ?>
</ol>
