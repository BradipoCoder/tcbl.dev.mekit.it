<?php
/**
 * Node Blog/News Full
 */
?>

<?php
  hide($content['links']);
  hide($content['comments']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">
        <?php print render($content); ?>

        <?php print render($content['comments']); ?>
      </div>
    </div>
  </div>
</div>