<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace TcblFeed\Plugins;

use TcblFeed\FeedItem;

class InstagramFeedPlugin extends FeedPlugin implements FeedPluginInterface {

  /**
   * InstagramFeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = []) {
    $this->feed_type = "instagram";

    parent::__construct($options);
  }

  /**
   * @return array
   */
  public function getFeeds(): array {

    $feeds = $this->getFakeFeeds();

    return $feeds;
  }
}

