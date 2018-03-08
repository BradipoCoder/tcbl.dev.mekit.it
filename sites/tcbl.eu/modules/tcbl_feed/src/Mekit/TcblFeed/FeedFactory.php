<?php
/**
 * Created by Adam Jakab.
 * Date: 30/01/18
 * Time: 12.16
 */

namespace Mekit\TcblFeed;

use Mekit\TcblFeed\Plugins\FeedPluginInterface;

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

    $defaultOptions = [
      "default" => [
        "max_items" => 3
      ],
      "plugin" => []
    ];
    $options = self::array_merge_recursive_distinct($defaultOptions, $options);

    dsm("GEN-OPTIONS: " . json_encode($options));

    FeedFactory::enumerateFeedPlugins();

    foreach (FeedFactory::$feed_plugins as $pluginClass) {
      $reflection = new \ReflectionClass($pluginClass);

      $pluginShortcode = $reflection->getConstant("SHORT_CODE");
      $pluginOptions = isset($options["plugin"][$pluginShortcode])
        ? self::array_merge_recursive_distinct($options["default"], $options["plugin"][$pluginShortcode])
        : $options["default"];

      dsm("GEN($pluginClass)[$pluginShortcode] plugin options: " . json_encode($pluginOptions));

      /** @var FeedPluginInterface $plugin */
      $plugin = $reflection->newInstance($pluginOptions);

      $pluginFeeds = $plugin->fetchFeeds();
      $pluginFeeds = FeedFactory::sortFeeds($pluginFeeds, "creation_date", "DESC");

      //truncate
      $pluginFeeds = array_slice($pluginFeeds, 0, $pluginOptions["max_items"]);

      //add to other feeds
      $feeds = array_merge($feeds, $pluginFeeds);
    }

    //sort feeds
    //@todo: sort here?

    //write feeds
    FeedFactory::writeFeedsFile($feeds);
  }

  /**
   * @param array $array1
   * @param array $array2
   *
   * @return array
   */
  private static function array_merge_recursive_distinct(array $array1, $array2)
  {
    $merged = $array1;

    if (is_array($array2))
      foreach ($array2 as $key => $val)
        if (is_array($array2[$key])){
          $merged[$key] = isset($merged[$key]) && is_array($merged[$key])
            ? self::array_merge_recursive_distinct($merged[$key], $array2[$key])
            : $array2[$key];
        } else {
          $merged[$key] = $val;
        }

    return $merged;
  }

  /**
   * Returns ann array of feeds according to the options passed
   * @param array $options
   *
   * @return array
   */
  public static function getFeeds($options = []) {
    $feeds = FeedFactory::readCachedFeedsFile();

    // FILTER FEEDS
    if (isset($options["filters"]) && is_array($options["filters"])) {
      foreach ($options["filters"] as $filterType => $filters) {
        if (empty($filterType) || empty($filters)) {
          continue;
        }
        switch ($filterType) {
          case "source":
            $feeds = FeedFactory::filterFeedsBySource($feeds, $filters);
            break;
          case "type":
            $feeds = FeedFactory::filterFeedsByType($feeds, $filters);
            break;
        }
      }
    }

    // ORDER FEEDS
    if (isset($options["ordering"]) && is_array($options["ordering"])) {
      $property = isset($options["ordering"]["property"]) ? $options["ordering"]["property"] : 'id';
      $order = isset($options["ordering"]["order"]) ? $options["ordering"]["order"] : 'ASC';
      $order = in_array($order, ["ASC", "DESC"]) ? $order : 'ASC';

      try {
        $feedItemReflection = new \ReflectionClass("\TcblFeed\FeedItem");
        if(!$feedItemReflection->hasProperty($property)) {
          $property = "id";
        }
      } catch(\ReflectionException $e) {
        // hmm - this would be a sad story
      }

      $feeds = FeedFactory::sortFeeds($feeds, $property, $order);
    }

    return $feeds;
  }

  /**
   * @param array $feeds
   * @param string $property
   * @param string $order
   *
   * @return array
   */
  protected static function sortFeeds($feeds, $property, $order) {
    //echo "<br />Sorting[$order] by: $property";
    switch($property)
    {
      case "id":
        if($order == "ASC") {
          usort($feeds, function(FeedItem $a, FeedItem $b) {
            return strcmp($a->getId(), $b->getId());
          });
        } else {
          usort($feeds, function(FeedItem $a, FeedItem $b) {
            return strcmp($b->getId(), $a->getId());
          });
        }
        break;
      case "title":
        if($order == "ASC") {
          usort($feeds, function(FeedItem $a, FeedItem $b) {
            return strcmp($a->getTitle(), $b->getTitle());
          });
        } else {
          usort($feeds, function(FeedItem $a, FeedItem $b) {
            return strcmp($b->getTitle(), $a->getTitle());
          });
        }
        break;
        case "creation_date":
        if($order == "ASC") {
          usort($feeds, function(FeedItem $a, FeedItem $b) {
            return $a->getCreationDate() >= $b->getCreationDate();
          });
        } else {
          usort($feeds, function(FeedItem $a, FeedItem $b) {
            return $b->getCreationDate() >= $a->getCreationDate();
          });
        }
        break;

    }

    return $feeds;
  }

  /**
   * Returns a filtered array of feeds
   *
   * @param array $feeds
   * @param array $filters
   *
   * @return array
   */
  protected static function filterFeedsBySource($feeds, $filters) {
    $answer = [];

    /** @var FeedItem $feed */
    foreach($feeds as $feed) {
      if(in_array($feed->getSource(), $filters)) {
        array_push($answer, $feed);
      }
    }

    return $answer;
  }

  /**
   * Returns a filtered array of feeds
   *
   * @param array $feeds
   * @param array $filters
   *
   * @return array
   */
  protected static function filterFeedsByType($feeds, $filters) {
    $answer = [];

    /** @var FeedItem $feed */
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
      drupal_get_path("module", "tcbl_feed") . "/src/Mekit/TcblFeed/Plugins/"
    );
    $pluginFiles = glob($pluginPath . '/*Plugin.php');

    //dpm($pluginFiles, "FEED PLUGIN FILES");

    foreach ($pluginFiles as &$pluginFile) {
      //require_once($pluginFile);
      $pluginClass = 'Mekit\\TcblFeed\\Plugins\\' . str_replace(
          '.php', '', str_replace(
          $pluginPath . '/', '', $pluginFile
        )
        );

      //dsm("plugin class: " . $pluginClass);
      //dpm(class_implements($pluginClass), "class-implements: " );

      if (in_array('Mekit\TcblFeed\Plugins\FeedPluginInterface', class_implements($pluginClass))) {
        array_push(FeedFactory::$feed_plugins, $pluginClass);
      }
    }
  }

  /**
   * Read feeds file in
   *
   * @return array
   */
  protected static function readCachedFeedsFile() {
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