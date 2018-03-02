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
   * @return string
   */
  public function getFeedSource(): string;

  /**
   * @return array
   */
  public function fetchFeeds(): array;
}