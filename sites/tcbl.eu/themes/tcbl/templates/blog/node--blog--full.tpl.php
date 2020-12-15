<?php
/**
 * Node Blog/News Full
 */
?>

<?php
  hide($content['links']);
  hide($content['comments']);
  hide($content['field_submitted']);
  hide($content['field_by']);
  hide($content['field_files'])
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">
        <div class="paragraphs-item-copy">
          <?php print render($content['body']); ?>
        </div>

        <?php print render($content); ?>

        <div class="paragraphs-item-copy">
          <?php print render($content['field_files']); ?>  
          <?php print render($content['field_by']); ?>
          <?php print render($content['comments']); ?>
        </div>
      </div>
    </div>
  </div>
</div>