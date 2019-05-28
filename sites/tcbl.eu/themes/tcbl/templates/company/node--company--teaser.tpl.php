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
  <div class="node-content">

    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>

    <a href="<?php print $node_url; ?>" class="a-block">
      <span class="company-head">
        <span class="company-logo">
          <?php print render($content['field_img'][0]); ?>
        </span>
        <span class="company-content">
          <span class="company-memb-level"><?php print render($content['field_ref_memb'][0]); ?></span>
          <?php print render($content['title_field'][0]); ?>
          <?php print render($content['contacts']); ?>
        </span>
      </span>
    </a>
  </div>
</div>