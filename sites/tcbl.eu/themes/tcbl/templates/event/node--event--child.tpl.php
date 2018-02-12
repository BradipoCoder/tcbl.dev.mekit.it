<?php
/**
 * Node Event Child
 *
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>
  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="same-h">
      <?php print render($content); ?>
    </div>
  </div>
</div>