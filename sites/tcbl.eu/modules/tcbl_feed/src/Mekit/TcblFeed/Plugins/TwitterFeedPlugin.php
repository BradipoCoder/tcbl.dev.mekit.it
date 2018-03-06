<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace Mekit\TcblFeed\Plugins;

use Mekit\TcblFeed\FeedItem;

class TwitterFeedPlugin extends FeedPlugin implements FeedPluginInterface {

  /**
   * TwitterFeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = []) {
    $this->feed_source = "twitter";

    parent::__construct($options);
  }

  /**
   * @return array
   */
  public function fetchFeeds(): array {

    $feeds = $this->generateFakeFeeds();

    return $feeds;
  }
}

