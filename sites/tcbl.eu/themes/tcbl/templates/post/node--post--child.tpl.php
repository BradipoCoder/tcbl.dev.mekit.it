<?php
/**
 * Node Post Child
 *
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content">
    <div class="margin-sm-r-2">
      <div class="row">
        <div class="col-sm-6">
          <?php print render($content['field_img']); ?>
        </div>
        <div class="col-sm-6">
          <div class="hidden-sm hidden-md hidden-lg">
            <?php print render($content); ?>
          </div>
          <div class="hidden-xs same-h">
            <?php print render($content); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>