<?php
/** @var \TcblFeed\FeedItem $feed_item */

/*  <pre><?php print_r($feed_item); ?></pre>  */
?>
<div class="col-sm-4">
  <div class="well">
    <h5>FEED ITEM - <?php print $feed_item->getTitle(); ?></h5>
    <code><?php print $feed_item->getType(); ?></code>
  </div>
</div>
