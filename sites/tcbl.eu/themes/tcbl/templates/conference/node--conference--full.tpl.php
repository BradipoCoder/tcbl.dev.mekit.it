<?php
/**
 * Node Conference Full
 */
?>

<?php
  hide($content['field_description']);
  hide($content['field_subtitle']);
  hide($content['links']);
  hide($content['field_date']);
  hide($content['field_location']);
  hide($content['footer']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>
  <div class="row">
    <div class="container">
      <div class="node-content"<?php print $content_attributes; ?>>
        <div class="conference-card">
          <div class="conference-overview-head margin-b-1">
            <h1>Overview</h1>
            <div class="conference-details">
              <?php print render($content['field_date'][0]); ?>
              <?php print render($content['where']); ?>
            </div>
          </div>
          <?php print render($content); ?>
          <?php print render($content['footer']); ?>
        </div>
      </div>
    </div>
  </div>
</div>