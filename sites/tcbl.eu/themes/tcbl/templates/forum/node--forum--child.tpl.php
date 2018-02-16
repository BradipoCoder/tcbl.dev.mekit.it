<?php
/**
 * Node Blog/News Full
 */
?>

<?php
  hide($content['links']);
  hide($content['comments']);
  hide($content['field_submitted']);
  hide($content['comment_count']);
  hide($content['comment_label']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="topic-item">
      <div class="topic-item--content">
        <?php print render($content); ?>
      </div>
      <div class="topic-item--date">
        <div class="topic-v-center">
          <?php print render($content['field_submitted']); ?>  
        </div>
      </div>
      <div class="topic-item--comments">
        <div class="topic-v-center">
          <span class="h3"><?php print render($content['comment_count']); ?></span> <span class="comment-label"><?php print render($content['comment_label']); ?></span>
        </div>
      </div>
    </div>
  </div>
</div>