<?php
/** @var \TcblFeed\FeedItem $feed_item */

?>
<div>
  <h5>FEED ITEM - <?php print $feed_item->getTitle(); ?></h5>
  <pre>
    <?php

    print_r($feed_item);

    ?>
  </pre>
</div>
