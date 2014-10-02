<form class="admin-form">
  <fieldset>
    <legend>Edit Article</legend>
    <label for="title">Title</label>
    <input type="text" id="title" name="title" size="50" value="<?php echo $title; ?>" />
    <textarea id="content" rows="20" cols="104"><?php echo $content; ?></textarea><br />
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
    <input type="button" value="Saved" disabled="disabled" class="button" />
    <input type="button" value="Cancel" class="publish button" />
    <input type="button" value="Publish" class="float publish button" />
  </fieldset>
</form>