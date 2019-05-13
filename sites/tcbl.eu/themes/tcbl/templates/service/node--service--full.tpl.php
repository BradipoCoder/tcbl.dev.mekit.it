<?php
/**
 * Node Service Full
 */
?>

<?php
  hide($content['links']);
  hide($content['pager']);
  hide($content['related']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">
        <div class="wrapper-service-img negative">
          <?php print render($content['field_img']); ?>
          <div class="service-over"></div>
          <?php print render($content['title_field']); ?>
          <hr class="hr-green">
        </div>

        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <?php print render($content); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="wrapper-posts">
        <div class="container">
          <?php print render($content['related']); ?>   
        </div>
      </div>
    </div>
    <?php print render($content['pager']); ?> 
  </div>
</div>