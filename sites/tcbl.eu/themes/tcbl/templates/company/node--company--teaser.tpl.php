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
    <a href="<?php print $node_url; ?>" class="a-block">
      <span class="company-logo">
        <?php print render($content['field_img'][0]); ?>
      </span>
      <span class="company-teaser-content">
        <?php print render($content['title_field'][0]); ?>
        <?php print render($content['contacts']); ?>
        <span class="small">
          <?php print render($content['body'][0]); ?>
        </span>
      </span>
    </a>
  </div>

</div>