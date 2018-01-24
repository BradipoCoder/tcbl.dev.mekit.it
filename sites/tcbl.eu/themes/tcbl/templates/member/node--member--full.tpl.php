<?php
/**
 * Node Member Full
 *
 */
?>

<?php
  hide($content['links']);
  hide($content['pager']);
  hide($content['webform']);
  hide($content['members']);

  $content['pager']['#prefix'] = '<div class="nhc-pager row margin-v-1">';
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">
        <?php print render($content['title_field']); ?>
        
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <?php print render($content['field_short']); ?>
          </div>
        </div>

        <?php print render($content['card']); ?>

        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 margin-b-2">
            <?php print render($content); ?>  
          </div>
        </div>
      </div>
    </div>
    
    <?php print render($content['webform']); ?> 
    <?php //print render($content['pager']); ?> 
  </div>
</div>

<div class="wrapper-members">
  <div class="container margin-v-2">
    <?php print render($content['members']); ?>    
  </div>
</div>