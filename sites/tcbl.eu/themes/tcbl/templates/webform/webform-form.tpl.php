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

  $form['submitted']['type']['#options'][''] = '- Tipologia * - ';

?>

<?php // Print out the main part of the form. ?>
<?php // Feel free to break this up and move the pieces within the array. ?>

<div class="row">
  <div class="col-md-6">
    <?php print drupal_render($form['submitted']['name']); ?>
    <div class="row">
      <div class="col-sm-6">
        <?php print drupal_render($form['submitted']['company']); ?>
      </div>
      <div class="col-sm-6">
        <?php print drupal_render($form['submitted']['type']); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <?php print drupal_render($form['submitted']['e_mail']); ?>
      </div>
      <div class="col-sm-6">
        <?php print drupal_render($form['submitted']['phone']); ?>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <?php print drupal_render($form['submitted']['phone']); ?>
    <?php print drupal_render($form['submitted']['message']); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <?php print drupal_render($form['submitted']['privacy']); ?>
  </div>
  <div class="col-md-6">
    <?php print drupal_render($form['submitted']); ?>
    <div class="text-right">
      <?php print drupal_render_children($form); ?>
    </div>
  </div>
</div>

<?php if (isset($form['preview'])) : ?>
  <div class="form-preview">
    <?php print drupal_render($form['preview']); ?> 
  </div>
<?php endif; ?>


  

  
