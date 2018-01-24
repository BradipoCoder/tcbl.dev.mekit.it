<?php
/**
 * Node Page Press
 */
?>

<?php
  hide($content['links']);
  hide($content['list']);
  hide($content['children']);
  hide($content['btm_form']);
  hide($content['webform']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">

        <div class="row">
          <div class="col-md-6">
            <?php print render($content['title_field']); ?>
            <?php print render($content['field_short']); ?>   
          </div>
          <div class="col-md-6">
            <?php print render($content['contacts']); ?>  
          </div>
        </div>        

        <?php print render($content['webform']); ?>
        <hr>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="wrapper-press">
    <div class="container margin-v-2">
      <?php print render($content['posts']); ?>
    </div>
  </div>
</div>