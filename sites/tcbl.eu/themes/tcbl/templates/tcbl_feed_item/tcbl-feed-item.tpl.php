<?php
/** @var \Mekit\TcblFeed\FeedItem $feed_item */
/** @var string $classes */

//print_r(get_defined_vars());

/*  <pre><?php print_r($feed_item); ?></pre>  */
?>
<div class="<?php print $classes; ?> col-sm-4">
  <div class="well">
    <h5><?php print $feed_item->getTitle(); ?></h5>
    <code><?php print $feed_item->getSource(); ?>/<?php print $feed_item->getType(); ?></code>
  </div>
</div>

