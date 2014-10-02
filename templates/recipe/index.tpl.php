<ul>
<?php foreach ($recipes as $recipe): ?>
<?php extract($recipe); ?>
  <li>
    <a href="<?php echo "http://{$base_url}{$base_path}/recipe/view/{$id}"; ?>"><?php echo $title; ?></a><br />
    <strong>Ingredients: </strong><?php echo $ingredients; ?>
  </li>
<?php endforeach; ?>
</ul>
