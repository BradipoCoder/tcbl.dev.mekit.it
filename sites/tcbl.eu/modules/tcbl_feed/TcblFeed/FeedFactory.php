<?php
/**
 * Created by Adam Jakab.
 * Date: 30/01/18
 * Time: 12.16
 */

namespace TcblFeed;

use TcblFeed\FeedItem;

/**
 * Class FeedFactory
 *
 * @package TcblFeed
 */
class FeedFactory {

  /** @var string */
  protected static $feeds_cache_file_uri = 'public://tcbl_feeds/feeds.ser';




  /**
   * @param array $options
   *
   * @return array
   */
  public static function getFeeds($options = [])
  {
    if(isset($options["fake_feeds"]["generate"]) && $options["fake_feeds"]["generate"])
    {
      FeedFactory::generateFakeFeeds($options);
    }

    $feeds = FeedFactory::readCachedFeedsFile($options);

    return $feeds;
  }

  /**
   * Read feeds file in
   *
   * @param array $options
   * @return array
   */
  protected static function readCachedFeedsFile($options = [])
  {
    $feeds = [];

    return $feeds;
  }

  /**
   * Generate fake feeds for testing purposes
   *
   * @param array $options
   *
   */
  protected static function generateFakeFeeds($options = [])
  {
    $feeds = [];
    $count = isset($options["fake_feeds"]["count"]) ? $options["fake_feeds"]["count"] : 5;

    for ($i = 1; $i <= $count; $i++)
    {
      $item = new FeedItem();
      $item->setType("facebook");
      $item->setTitle("Item #".$i);
      $item->setContent("something...");
      $item->setDate(new \DateTime());
      $item->setUrl("https://mekit.it");
      array_push($feeds, $item);
    }

    //write file to FS
    $flatData = serialize($feeds);
    $feedDir = dirname(FeedFactory::$feeds_cache_file_uri);
    file_prepare_directory($feedDir, FILE_CREATE_DIRECTORY&&FILE_MODIFY_PERMISSIONS);
    file_save_data($flatData, FeedFactory::$feeds_cache_file_uri,FILE_EXISTS_REPLACE);
  }

}