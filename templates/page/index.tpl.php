<ul>
<?php foreach($pages as $page): ?>
<?php extract($page); ?>
  <li><a href="<?php echo "http://{$base_url}{$base_path}/page/view/{$id}"?>"><?php echo $title; ?></a></li>
<?php endforeach; ?>
</ul>
