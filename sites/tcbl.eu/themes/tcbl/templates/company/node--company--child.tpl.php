<?php
/**
 * Node Company Child
 *
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content margin-b-05">
    <a href="<?php print $node_url; ?>" class="a-block a-company">
      <span class="company-logo">
        <?php print render($content['field_img'][0]); ?>
      </span>
      <span class="company-content">
        <?php print render($content['title_field'][0]); ?>
      </span>
    </a>
  </div>

</div>