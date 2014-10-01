<ul>
<?php foreach ($recipes as $recipe): ?>
  <li><a href="<?php echo "http://{$base_url}{$base_path}/recipe/view/{$recipe->getId()}"; ?>"><?php echo $recipe->getTitle(); ?></a></li>
<?php endforeach; ?>
</ul>
