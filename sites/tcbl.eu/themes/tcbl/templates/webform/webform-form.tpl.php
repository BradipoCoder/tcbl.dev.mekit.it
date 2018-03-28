<?php

/**
 * Webform form
 */

?>
<?php
  // Print out the progress bar at the top of the page
  print drupal_render($form['progressbar']);

  // Print out the preview message if on the preview page.
  if (isset($form['preview_message'])) {
    print '<div class="alert alert-info">';
    print drupal_render($form['preview_message']);
    print '</div>';
  }
?>

<?php // Print out the main part of the form. ?>
<?php // Feel free to break this up and move the pieces within the array. ?>


<div class="row margin-v-2">
  <div class="col-sm-6">
    <?php print drupal_render($form['submitted']['firstname']); ?>
    <?php print drupal_render($form['submitted']['lastname']); ?>
    <?php print drupal_render($form['submitted']['email']); ?>
    <?php print drupal_render($form['submitted']['companyName']); ?>
  </div>
  <div class="col-sm-6">
    <?php print drupal_render($form['submitted']['address']); ?>
    <div class="row">
      <div class="col-sm-6">
        <?php print drupal_render($form['submitted']['city']); ?>
      </div>
      <div class="col-sm-6">
        <?php print drupal_render($form['submitted']['cap']); ?>
      </div>
    </div>
    <?php print drupal_render($form['submitted']); ?>
    
    <div class="text-right margin-t-1">
      <?php print drupal_render_children($form); ?>
    </div>
  </div>
</div>

<?php if (isset($form['preview'])) : ?>
  <div class="form-preview">
    <?php print drupal_render($form['preview']); ?> 
  </div>
<?php endif; ?>


  

  
