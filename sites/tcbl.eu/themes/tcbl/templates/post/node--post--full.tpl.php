<?php
/**
 * Node Post Full
 */
?>

<?php
  hide($content['links']);
  hide($content['field_form_title']);
  hide($content['field_date']);
  hide($content['field_ref_cat']);
  hide($content['pager']);
  hide($content['webform']);
  hide($content['cat_link']);
  hide($content['share']);
?>

<div class="row">
  <div class="container">
    <div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

      <?php print render($title_prefix); ?>
      <?php print render($title_suffix); ?>
  
      <div class="node-content"<?php print $content_attributes; ?>>
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="margin-sm-h-1">
              <?php print render($content['cat_date']); ?>
              <?php print render($content['title_field']); ?>
              <?php print render($content['field_short']); ?>
            </div>
            <hr class="margin-v-15">
            <?php print render($content); ?>

            <hr>
            <div class="row margin-v-1">
              <div class="col-sm-6 copy">
                <?php print render($content['cat_link']); ?>
              </div>
              <div class="col-sm-6">
                <div class="text-right text-xs-left">
                  <?php print render($content['share']); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php print render($content['webform']); ?>

<?php print render($content['pager']); ?>