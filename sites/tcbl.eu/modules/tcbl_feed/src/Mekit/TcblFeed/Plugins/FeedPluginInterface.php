<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace Mekit\TcblFeed\Plugins;

/**
 * Interface FeedPluginInterface
 *
 * @package Mekit\TcblFeed\Plugins
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