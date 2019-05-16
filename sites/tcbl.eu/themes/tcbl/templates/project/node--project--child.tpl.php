<?php
/**
 * Node Project Child
 *
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> col-md-4"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>
  <div class="node-content same-h"<?php print $content_attributes; ?>>
    <?php print render($content['field_img']); ?>
    <div class="project-child-content">
      <?php print render($content); ?>
    </div>
  </div>
</div>