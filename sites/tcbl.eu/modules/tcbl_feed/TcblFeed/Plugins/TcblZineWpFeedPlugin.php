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
   * @return array
   */
  public function getFeeds(): array {

    $feeds = $this->getFakeFeeds("tcbl_zine");

    return $feeds;
  }
}

