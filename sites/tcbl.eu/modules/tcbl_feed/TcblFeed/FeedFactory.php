<?php
/**
 * Created by Adam Jakab.
 * Date: 30/01/18
 * Time: 12.16
 */

namespace TcblFeed;

//use TcblFeed\FeedItem;

/**
 * Class FeedFactory
 *
 * @package TcblFeed
 */
class FeedFactory {

  /** @var string */
  protected static $feeds_cache_file_uri = 'public://tcbl_feeds/feeds.ser';

  /** @var array - list of plugins able to generate feed items */
  protected static $feed_plugins = [];


  /**
   * @param array $options
   *
   * @throws \ReflectionException
   */
  public static function generateFeeds($options = []) {
    $feeds = [];

    FeedFactory::enumerateFeedPlugins();

    foreach (FeedFactory::$feed_plugins as $pluginClass) {
      $reflection = new \ReflectionClass($pluginClass);
      /** @var \TcblFeed\Plugins\FeedPluginInterface $plugin */
      $plugin = $reflection->newInstance($options);
      $pluginFeeds = $plugin->getFeeds();
      $feeds = array_merge($feeds, $pluginFeeds);
    }

    //sort feeds

    //write feeds
    FeedFactory::writeFeedsFile($feeds);
  }

  /**
   * Returns ann array of feeds according to the options passed
   * @param array $options
   *
   * @return array
   */
  public static function getFeeds($options = []) {
    $feeds = FeedFactory::readCachedFeedsFile($options);

    if (isset($options["filters"]) && is_array($options["filters"])) {
      foreach ($options["filters"] as $filterType => $filters) {
        if (empty($filterType) || empty($filters)) {
          continue;
        }
        switch ($filterType) {
          case "type":
            $feeds = FeedFactory::filterFeedsByType($feeds, $filters);
            break;
        }
      }
    }

    return $feeds;
  }

  /**
   * Returns array of feeds where types correspond to types in filter
   * @param array $feeds
   * @param array $filters
   *
   * @return array
   */
  protected static function filterFeedsByType($feeds, $filters) {
    $answer = [];

    /** @var \TcblFeed\FeedItem $feed */
    foreach($feeds as $feed) {
      if(in_array($feed->getType(), $filters)) {
        array_push($answer, $feed);
      }
    }

    return $answer;
  }

  /**
   * check and load plugins
   */
  protected static function enumerateFeedPlugins() {
    $pluginPath = drupal_realpath(
      drupal_get_path("module", "tcbl_feed") . "/TcblFeed/Plugins/"
    );
    $pluginFiles = glob($pluginPath . '/*Plugin.php');

    foreach ($pluginFiles as &$pluginFile) {
      require_once($pluginFile);
      $pluginClass = 'TcblFeed\\Plugins\\' . str_replace(
          '.php', '', str_replace(
          $pluginPath . '/', '', $pluginFile
        )
        );
      if (in_array('TcblFeed\Plugins\FeedPluginInterface', class_implements($pluginClass))) {
        array_push(FeedFactory::$feed_plugins, $pluginClass);
      }
    }
  }

  /**
   * Read feeds file in
   *
   * @param array $options
   *
   * @return array
   */
  protected static function readCachedFeedsFile($options = []) {
    $feeds = [];

    $fileRealPath = drupal_realpath(FeedFactory::$feeds_cache_file_uri);
    if ($fileRealPath && file_exists($fileRealPath)) {
      $flatData = file_get_contents($fileRealPath);
      if ($flatData && !empty($flatData)) {
        $feeds = unserialize($flatData);
      }
    }

    return $feeds;
  }

  /**
   * Serializes and writes out the feeds
   *
   * @param $feeds
   */
  protected static function writeFeedsFile($feeds) {
    $flatData = serialize($feeds);
    $feedDir = dirname(FeedFactory::$feeds_cache_file_uri);
    file_prepare_directory(
      $feedDir, FILE_CREATE_DIRECTORY
                && FILE_MODIFY_PERMISSIONS
    );
    file_save_data($flatData, FeedFactory::$feeds_cache_file_uri, FILE_EXISTS_REPLACE);
  }
}