<?php
/**
 * Node Resource Full
 */
?>

<?php
  hide($content['links']);
  hide($content['list']);
  hide($content['children']);
  hide($content['field_ref_res_type']);
  hide($content['field_img']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">

        <div class="margin-v-05">
          <span class="sruns-label">
            <?php print render($content['type_label']); ?>
          </span>
        </div>

        <div class="row">
          <div class="col-sm-6 col-md-8">
            <div class="margin-sm-r-1">
              <?php print render($content); ?>
            </div>
          </div>

          <?php if ($type_tid !== '247') : ?>
            <div class="col-sm-6 col-md-4">
              <?php print render($content['field_img']); ?>
            </div>
          <?php endif ;?>
        </div>

        <div class="margin-v-1">
          <a href="<?php print url('shortruns/form'); ?>"><i class="fa fa-arrow-left"></i> Short Runs check-list</a>
        </div>
      </div>
    </div>
  </div>
</div>