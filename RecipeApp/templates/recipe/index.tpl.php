<?php foreach ($recipes as $recipe): ?>
  <h2><a href="<?php echo "http://{$base_url}{$base_path}/recipe/view/{$recipe->getId()}"; ?>"><?php echo $recipe->getTitle(); ?></a></h2>
<?php endforeach; ?>