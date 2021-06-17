<div>
  <div class="row column text-center">
  </div>
</div>
<hr>

<div class="row column">
  <h3>Edit details</h3>
  <div class="row column text-left">
      <?php $validation = \Config\Services::validation(); ?>
<!--    <form method="post">-->
      <?php echo form_open_multipart(); ?>
      <label>Name</label>
      <input type="text" name="name" value="<?php echo $property['name'] ?>" />
      <?php if ($validation->hasError('name')): ?>
        <div class="callout alert"><?php echo $validation->getError('name'); ?></div>
      <?php endif; ?>
      <label>Description</label>
      <textarea name="description"><?php echo $property['description'] ?></textarea>
      <?php if ($validation->hasError('description')): ?>
          <div class="callout alert"><?php echo $validation->getError('description'); ?></div>
      <?php endif; ?>
      <input type="file" name="image_file" id="image_file">
      <input class="button success" type="submit" value="SAVE" /> 
    </form>
    </div>
  <br/>
</div>

