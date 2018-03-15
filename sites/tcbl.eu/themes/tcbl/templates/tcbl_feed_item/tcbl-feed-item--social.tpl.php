<?php
/** @var \Mekit\TcblFeed\FeedItem $feed_item */
/** @var string $classes */
/** @var string $fontawesome_icon */


?>


<div class="<?php print $classes; ?> col-sm-6 col-md-3 margin-b-05">
  <a href="<?php print $url; ?>" target="_blank">
    <span class="content">
      <?php if(($source == 'instagram') && $img_path): ?>
        <span class="feed-img feed-img-instagram">
          <span class="feed-img feed-img-zine" style="background: url('<?php print $img_path; ?>') no-repeat center center;"></span>
        </span>
      <?php endif; ?>

      <i class="<?php print $fontawesome_icon; ?>" aria-hidden="true"></i>

      <?php if ($source !== 'instagram'): ?>
        <span class="feed-date small text-italic"><?php print $date; ?></span>
        
        <span class="feed-bottom">
          <span class="feed-message small text-italic">
            <?php print $message; ?>     
          </span>
          <span class="feed-author">
            <?php print render($avatar); ?>
            <span class="h6 text-primary"><?php print $name; ?></span>
          </span>
        </span>
      <?php endif; ?>
    </span>
  </a>
</div>
