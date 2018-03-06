<?php
/** @var \Mekit\TcblFeed\FeedItem $feed_item */
/** @var string $classes */

?>


<div class="<?php print $classes; ?> col-sm-1">
  <div class="content">
    <a href="<?php print $feed_item->getUrl(); ?>" target="_blank">
      <?php if($feed_item->getPictureUrl()): ?>
        <div class="image-content">
          <img src="<?php print $feed_item->getPictureUrl(); ?>" class=""/>

        </div>
      <?php endif; ?>

      <div class="feed-title">
        <span><?php print $feed_item->getTitle(); ?></span>
      </div>
    </a>
  </div>
</div>
