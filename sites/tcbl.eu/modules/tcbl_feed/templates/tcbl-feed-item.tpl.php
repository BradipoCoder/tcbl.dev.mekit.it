<?php
/** @var \TcblFeed\FeedItem $feed_item */
/** @var string $classes */
?>
<div class="<?php print $classes; ?> col-sm-4">
  <div class="well">
    <h5><?php print $feed_item->getTitle(); ?></h5>
    <code>TYPE: <?php print $feed_item->getType(); ?></code>
    <code>DATE: <?php print $feed_item->getFormattedCreationDate(); ?></code>
    <pre class="dump"><?php print print_r($feed_item->getPropertyArray(), true); ?></pre>
  </div>
</div>

