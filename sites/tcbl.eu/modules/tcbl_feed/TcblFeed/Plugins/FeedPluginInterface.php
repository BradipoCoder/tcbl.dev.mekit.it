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
   * @param array $options
   *
   * @return array
   */
  public function getFeeds($options = []):array;
}