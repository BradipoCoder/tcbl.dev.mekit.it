<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.30
 */

namespace Mekit\TcblFeed\Plugins;

use Mekit\TcblFeed\FeedItem;

class FeedPlugin {
  /** @var string */
  protected $feed_source;

  /** @var int */
  protected $max_feed_count = 5;

  /**
   * FeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct($options = []) {
    //
  }

  /**
   * @return string
   */
  public function getFeedSource(): string {
    return $this->feed_source;
  }

  /**
   * Normalizes Rss object by removing @attributes element and assigning the
   * contained key/value pairs to its parent
   *
   * @param mixed $object
   *
   * @return mixed
   */
  protected function fixRssObjectRecursively($object) {
    if (is_object($object)) {
      $attributesKeyName = "@attributes";
      if (property_exists($object, $attributesKeyName)) {
        foreach ($object->$attributesKeyName as $k => $v) {
          $object->$k = $v;
        }
        unset($object->$attributesKeyName);
      }
    }

    if (is_array($object) || is_object($object)) {
      foreach ($object as $k => &$v) {
        $v = $this->fixRssObjectRecursively($v);
      }
    }

    return $object;
  }

  /**
   * @param \SimpleXMLElement $el
   *
   * @return \SimpleXMLElement
   */
  protected function fixRssXmlRecursively(\SimpleXMLElement $el) {
    return $el;
  }

  /**
   * @param string $url
   *
   * @return \stdClass
   */
  protected function fetchRssXmlAndConvertToObject($url) {
    $answer = new \stdClass();

    $content = @file_get_contents($url);
    if ($content) {
      $invalid_characters = '/[^\x9\xa\x20-\xD7FF\xE000-\xFFFD]/';
      $content = preg_replace($invalid_characters, '', $content);
      $xml = simplexml_load_string($content);
      if ($xml instanceof \SimpleXMLElement) {
        $xml = $this->fixRssXmlRecursively($xml);
        $jsonObject = @json_decode(@json_encode($xml));
        //dpm($jsonObject, $url);
        $answer = $this->fixRssObjectRecursively($jsonObject);
        //dpm($jsonObject, "fixed: " . $url);
      }
    }

    return $answer;
  }

  /**
   * @return array
   */
  protected function generateFakeFeeds(): array {
    $feeds = [];

    $randomDateStart = new \DateTime('now - 1 months');
    $randomDateFinish = new \DateTime();

    for ($i = 1; $i <= $this->max_feed_count; $i++) {
      $id = rand(1, 9999);
      $item = new FeedItem();
      $item->setId($id);
      $item->setSource($this->feed_source);
      $item->setType("post");
      $item->setTitle(
        ucfirst($this->feed_source) . " Item #" . str_pad($id, 4, "0", STR_PAD_LEFT)
      );
      $item->setMessage("something interesting...");
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
  private function getFakeRandomDate($date1, $date2) {
    $answer = new \DateTime();
    try {
      $random_u = random_int($date1->format('U'), $date2->format('U'));
    } catch(\Exception $e) {
      $random_u = $date1->format('U');
    }
    $answer->setTimestamp($random_u);

    return $answer;
  }

}