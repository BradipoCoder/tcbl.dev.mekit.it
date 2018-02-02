<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.30
 */

namespace TcblFeed\Plugins;

use TcblFeed\FeedItem;

class FeedPlugin {
  /** @var int */
  protected $max_feed_count = 5;

  /**
   * FeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct($options = [])
  {
    $this->max_feed_count = isset($options["feed_item_per_plugin"]) && intval($options["feed_item_per_plugin"])
      ? $options["feed_item_per_plugin"]
      : $this->max_feed_count;


  }

  /**
   * @param $type
   *
   * @return array
   */
  protected function getFakeFeeds($type): array {
    $feeds = [];

    for ($i = 1; $i <= $this->max_feed_count; $i++)
    {
      $item = new FeedItem();
      $item->setType($type);
      $item->setTitle("Item #".$i);
      $item->setMessage("something...");
      $item->setCreationDate(new \DateTime());
      $item->setUrl("https://mekit.it");
      array_push($feeds, $item);
    }


    return $feeds;
  }
}