Add the credentials for a user with CREATE/UPDATE/DELETE privileges to config.php.

Request http://localhost/install.php from a brwoser with the app installed in the web root.
This will create the database, schema and add dummy data.

Request http://localhost/recipes/view/1.
This will demonstrate the process of fetching a recipe from the database.

Creation and update functionality is not implmented. Neither has the view layer.

Apache mod_rewrite and overrides must be enabled.