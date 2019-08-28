<?php
/**
 * Node Resource Teaser
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> col-md-4 col-sm-6 margin-b-1"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <a href="<?php print $node_url; ?>" class="a-block">
    <span class="card">
      <?php print render($content['field_img'][0]); ?>
      <span class="card__label">
        <?php print render($content['type_label']); ?>
      </span>
      <span class="card__content sameh">
        <span class="xs muted"><?php print render($content['field_ref_res_type'][0]); ?></span>
        <span class="h5"><?php print $node->title; ?></span>
      </span>
    </span>
  </a>
</div>
