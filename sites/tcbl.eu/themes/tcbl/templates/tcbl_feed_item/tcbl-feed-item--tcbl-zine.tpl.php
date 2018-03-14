<?php
/** @var \Mekit\TcblFeed\FeedItem $feed_item */
/** @var string $classes */

?>
<div class="<?php print $classes; ?> col-sm-6 col-md-3 margin-b-05 same-h">
  <div class="content">
    <a href="<?php print $feed_item->getUrl(); ?>" target="_blank">
      <span class="feed-img feed-img-zine" style="background: url('<?php print $img_path; ?>') no-repeat center center;"></span>
    </a>

    <h5 class="margin-v-025 text-italic"><a href="<?php print $feed_item->getUrl(); ?>" target="_blank" class="text-primary"><?php print $title; ?></a></h5>
  </div>
</div>