<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace TcblFeed\Plugins;

/**
 * Interface FeedPluginInterface
 *
 * @package TcblFeed\Plugins
 */
interface FeedPluginInterface {

  /**
   * @return array
   */
  public function getFeeds():array;
}