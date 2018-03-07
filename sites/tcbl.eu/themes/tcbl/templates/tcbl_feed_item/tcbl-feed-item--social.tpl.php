<?php
/** @var \Mekit\TcblFeed\FeedItem $feed_item */
/** @var string $classes */
/** @var string $fontawesome_icon */


?>


<div class="<?php print $classes; ?> col-sm-2">
  <div class="content">
    <a href="<?php print $feed_item->getUrl(); ?>" target="_blank">
      <?php if($feed_item->getSource() == "instagram"): ?>
        <?php if($feed_item->getPictureUrl()): ?>
          <div class="image-content">
            <img src="<?php print $feed_item->getPictureUrl(); ?>" class=""/>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <i class="<?php print $fontawesome_icon; ?>" aria-hidden="true"></i>

      <?php if($feed_item->getSource() != "instagram"): ?>
        <div class="feed-date">
          <span><?php print $feed_item->getFormattedCreationDate("H:i M j Y"); ?></span>
        </div>
      <?php endif; ?>

      <?php if($feed_item->getSource() != "instagram"): ?>
        <div class="feed-message">
          <span><?php print $feed_item->getTrimmedMessage(180); ?></span>
        </div>
      <?php endif; ?>

      <?php if($feed_item->getSource() != "instagram"): ?>
        <div class="feed-author">
          <span><?php print $feed_item->getPostedByName(); ?></span>
        </div>
      <?php endif; ?>

    </a>
  </div>
</div>
