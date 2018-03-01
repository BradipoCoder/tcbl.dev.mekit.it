<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.30
 */

namespace TcblFeed\Plugins;

use TcblFeed\FeedItem;

class FeedPlugin {
  /** @var string */
  protected $feed_type;

  /** @var int */
  protected $max_feed_count = 5;

  /**
   * FeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct($options = []) {
    $this->max_feed_count = isset($options["feed_item_per_plugin"])
                            && intval($options["feed_item_per_plugin"])
      ? $options["feed_item_per_plugin"]
      : $this->max_feed_count;


  }

  /**
   * @return array
   */
  protected function getFakeFeeds(): array {
    $feeds = [];

    $randomDateStart = new \DateTime('now - 18 months');
    $randomDateFinish = new \DateTime();

    for ($i = 1; $i <= $this->max_feed_count; $i++) {

      $id = rand(1,9999);

      $item = new FeedItem();
      $item->setId($id);
      $item->setType($this->feed_type);
      $item->setTitle(ucfirst($this->feed_type) . " Item #" . str_pad($id, 4, "0", STR_PAD_LEFT));
      $item->setMessage("something...");
      $item->setCreationDate(new \DateTime());
      $item->setCreationDate($this->getFakeRandomDate($randomDateStart, $randomDateFinish));
      $item->setUrl("https://mekit.it");
      array_push($feeds, $item);
    }

    return $feeds;
  }

  /**
   * @param \DateTime $date1
   * @param \DateTime $date2
   *
   * @return \DateTime
   */
  private function getFakeRandomDate($date1, $date2){
    $answer = new \DateTime();
    try {
      $random_u = random_int($date1->format('U'), $date2->format('U'));
    } catch(\Exception $e){
      $random_u = $date1->format('U');
    }
    $answer->setTimestamp($random_u);

    return $answer;
  }

}