<?php
/**
 * Node Project Full
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
        <div class="paragraphs-item-chapter">
          <div class="chapter-title">About</div>
          <div class="container-text margin-b-15">
            <?php print render($content['body']); ?>
          </div>
        </div>

        <?php print render($content['field_content']); ?>

        <?php if ($company) : ?>
          <div class="paragraphs-item-chapter">
            <div class="chapter-title chapter-title--small">A project by</div>
            <div class="chapter-content">
              <?php print render($content['field_ref_labs']); ?> 
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>