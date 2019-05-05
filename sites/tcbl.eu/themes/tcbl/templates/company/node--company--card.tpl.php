<?php
/**
 * Node Company Card
 * - this is a fake view mode (not exists in the DB)
 * - it's used in tcbl_labs/include/data.php
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> col-md-3"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content margin-b-05">
    <a href="<?php print $node_url; ?>" class="a-block">
      <span class="card">
        <span class="card__content same-h">
          <span class="card__logo">
            <?php print render($content['field_img'][0]); ?>
          </span>
          <span class="company-memb-level"><?php print render($content['field_ref_memb'][0]); ?></span>
          <?php print render($content['title_field'][0]); ?>
          <?php print render($content['contacts']); ?>
          <span class="company-body">
            <?php print render($content['body'][0]); ?>
          </span>
          <?php if ($has_networks) : ?>
            <hr>
            <span class="card__footer">
              <span class="card__cta">View on</span>
              <?php print render($content['networks']); ?>
            </span>
          <?php endif; ?>
        </span>
      </span>
    </a>
  </div>

</div>