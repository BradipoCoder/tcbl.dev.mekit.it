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
    <div class="row">
      <div class="container">
        <?php print render($content['title_field']); ?>
        <?php print render($content['field_short']); ?>
        <?php print render($content['field_img']); ?>

        <?php print render($content['cat_menu']); ?>
        <?php print render($content['posts']); ?>

        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <?php print render($content); ?>
          </div>
        </div>

        <?php print render($content['webform']); ?>
        <?php print render($content['list']); ?>
        <?php print render($content['children']); ?>
        <?php print render($content['press']); ?>
      </div>
    </div>
  </div>
</div>

<?php print render($content['btm_form']); ?>