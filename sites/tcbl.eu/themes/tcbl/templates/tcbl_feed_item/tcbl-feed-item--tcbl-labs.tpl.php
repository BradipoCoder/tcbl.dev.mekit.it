<?php
/** @var \Mekit\TcblFeed\FeedItem $feed_item */
/** @var string $classes */
?>
<div class="<?php print $classes; ?> col-sm-4 margin-b-05">
  <div class="content">
    <a href="<?php print $url; ?>" target="_blank">
      <span class="feed-img feed-img-labs" style="background: url('<?php print $img_path; ?>') no-repeat center center;"></span>
      <span class="feed-over-content negative">
        <span class="feed-title h3"><?php print $title; ?></span>
        <span class="feed-bottom">
          <span class="feed-description small"><?php print $description; ?></span>
          <span class="feed-date text-italic small"><?php print $date; ?></span>
        </span>
      </span>
    </a>
  </div>
</div>

