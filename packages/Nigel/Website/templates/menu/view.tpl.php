<ul>
  <?php foreach ($menu as $item): ?>
  <?php extract($item); ?>
  <li><a href="<?php echo $href; ?>"><?php echo $text; ?></a></li>
  <?php endforeach; ?>
</ul>