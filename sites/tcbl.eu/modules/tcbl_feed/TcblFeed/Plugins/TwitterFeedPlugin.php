<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace TcblFeed\Plugins;

use TcblFeed\FeedItem;

class TwitterFeedPlugin extends FeedPlugin implements FeedPluginInterface {

  /**
   * @return array
   */
  public function getFeeds(): array {

    $feeds = $this->getFakeFeeds("twitter");

    return $feeds;
  }
}

