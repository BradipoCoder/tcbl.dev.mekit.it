<?php

/**
 * Webform form - Lab evaluation process End
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


<div class="margin-b-1">
  <?php print drupal_render($form['submitted']); ?>
  <div class="margin-t-1">
    <?php print drupal_render_children($form); ?>
  </div>
</div>

<?php if (isset($form['preview'])) : ?>
  <div class="form-preview">
    <?php print drupal_render($form['preview']); ?> 
  </div>
<?php endif; ?>


  

  
