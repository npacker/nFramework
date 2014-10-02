<ul>
<?php foreach ($recipes as $recipe): ?>
  <li>
    <a href="<?php echo "http://{$base_url}{$base_path}/recipe/view/{$recipe['id']}"; ?>"><?php echo $recipe['title']; ?></a><br />
    <strong>Ingredients: </strong><?php echo $recipe['ingredients']; ?>
  </li>
<?php endforeach; ?>
</ul>
