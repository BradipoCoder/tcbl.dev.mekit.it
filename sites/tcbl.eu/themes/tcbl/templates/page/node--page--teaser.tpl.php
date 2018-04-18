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
  hide($content['webform']);
  hide($content['press']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-5">
          <?php print render($content['field_short']); ?>
          <?php print render($content['more']); ?>
        </div>
        <?php if ($has_video) : ?>
          <div class="col-md-6 col-lg-5 col-lg-offset-1">
            <?php print render($content['video']); ?>  
          </div>  
        <?php endif; ?>
      </div>
      <?php print render($content); ?>
    </div>
  </div>
</div>