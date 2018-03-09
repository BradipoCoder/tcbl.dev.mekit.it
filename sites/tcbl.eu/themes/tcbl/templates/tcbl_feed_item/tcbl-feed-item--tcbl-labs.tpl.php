<?php
/** @var \Mekit\TcblFeed\FeedItem $feed_item */
/** @var string $classes */

?>
<div class="<?php print $classes; ?> col-sm-4">
  <div class="content">
    <a href="<?php print $feed_item->getUrl(); ?>" target="_blank">
      <div class="image-content">
        <img src="<?php print $feed_item->getPictureUrl(); ?>" class=""/>
<!--        <img src="https://picsum.photos/400/300/?random&blur" class=""/>-->
      </div>
      <div class="feed-title">
        <span><?php print $feed_item->getTitle(); ?></span>
      </div>
    </a>
  </div>
</div>

