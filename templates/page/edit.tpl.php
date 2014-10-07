<form class="admin-form" action="<?php echo $action; ?>" method="post">
	<fieldset>
		<legend>Edit Page</legend>
		<label for="title">Title:</label>
		<input type="text" id="title"	name="title" size="50" value="<?php echo $title; ?>" />
		<label for="content">Content:</label>
		<textarea id="content" name="content" rows="20" cols="104"><?php echo $content; ?></textarea>
		<br />
		<input type="button" value="Saved" disabled="disabled" class="button" />
		<input type="button" value="Cancel"	class="publish button" />
		<input type="submit" value="Publish" class="float publish button" />
	</fieldset>
</form>
