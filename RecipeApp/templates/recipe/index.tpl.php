<ul>
<?php foreach ($recipes as $recipe): ?>
  <li><a href="<?php echo "http://{$base_url}{$base_path}/recipe/view/{$recipe['id']}"; ?>"><?php echo $recipe['title']; ?></a></li>
<?php endforeach; ?>
</ul>
