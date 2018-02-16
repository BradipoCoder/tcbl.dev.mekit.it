<?php
/**
 * Node Blog/News Full
 */
?>

<?php
  hide($content['links']);
  hide($content['comments']);
  hide($content['field_submitted']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row">
      <div class="container">
        <?php print render($content['faq']); ?>
        <div class="wrapper-topic">
          <div class="topic-header">
            <div class="topic-by">
              <h6 class="margin-v-0">Submitted by <span class="h3"><?php print render($content['field_author'][0]); ?></span></h6>
            </div>
            <div class="topic-submitted small text-muted">
              <?php print render($content['field_submitted'][0]); ?>
            </div>
            <div class="avatar">
              <img src="https://cdn.ycombinator.com/images/people/gustaf-f076e8c4.jpg" class="img-responsive"/>
            </div>  
          </div>
          
          <div class="topic-container">
            <div class="topic-content margin-b-1">
              <?php print render($content); ?>
            </div>
            <?php print render($content['comments']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>