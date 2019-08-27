<?php
/**
 * Node Question Full
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <?php print render($content); ?>
  </div>
</div>