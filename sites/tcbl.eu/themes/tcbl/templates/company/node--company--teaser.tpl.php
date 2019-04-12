<?php
/**
 * Node Company Teaser
 *
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content margin-b-15">
    <?php print render($content['field_logo']); ?>
    <div class="company-teaser-content">
      <?php print render($content); ?>
    </div>
  </div>

</div>