<?php
/**
 * Node Page Full
 */
?>

<?php
  hide($content['links']);
  hide($content['list']);
  hide($content['children']);
  hide($content['btm_form']);
  hide($content['press']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">
        <?php if ($has_image) : ?>
          <div class="row">
            <div class="col-sm-6 col-md-8">
              <div class="margin-sm-r-1">
                <?php print render($content['body']); ?>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <?php print render($content['field_image']); ?>
            </div>
          </div>
        <?php endif; ?>
        <?php print render($content); ?>
      </div>
    </div>
  </div>
</div>