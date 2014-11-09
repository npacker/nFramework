<ul>
<?php foreach ($pages as $page): ?>
<?php extract((array) $page) ?>
  <li><a href="<?php echo $base_url, $base_path, '/page/', $id ?>"><?php echo $title ?></a></li>
<?php endforeach ?>
</ul>
