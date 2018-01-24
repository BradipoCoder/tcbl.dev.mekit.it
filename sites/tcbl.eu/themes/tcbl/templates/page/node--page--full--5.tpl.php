<?php
/**
 * Node Page Contatti
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

      </div>
    </div>
  </div>
</div>