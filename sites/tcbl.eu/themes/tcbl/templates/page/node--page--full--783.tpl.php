<?php
/**
 * Node Page Full (foundation-membership)
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
        <div class="row">
          <div class="col-lg-8">
            <?php print render($content['body']); ?>
          </div>
        </div>

        <?php print render($content); ?>
      </div>
    </div>
  </div>
</div>