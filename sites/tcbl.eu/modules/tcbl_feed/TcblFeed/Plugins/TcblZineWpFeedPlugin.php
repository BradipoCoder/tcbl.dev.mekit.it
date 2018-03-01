<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace TcblFeed\Plugins;

use TcblFeed\FeedItem;

class TcblZineWpFeedPlugin extends FeedPlugin implements FeedPluginInterface {

  /**
   * TcblZineWpFeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = []) {
    $this->feed_source = "tcbl_zine";

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

