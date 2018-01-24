<?php
/**
 * Node
 *
 * Hook suggestions examples:
 *
 *  node--child.tpl.php
 *  node--child--1.tpl.php
 *  node--type.tpl.php
 *  node--type--1.tpl.php
 *  node--type--child.tpl.php
 *  node--type--child--1.tpl.php
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
    <?php print render($content); ?>
  </div>

</div>