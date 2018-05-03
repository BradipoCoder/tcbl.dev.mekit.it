<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace Mekit\TcblFeed\Plugins;

use Mekit\TcblFeed\FeedItem;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;

class FacebookFeedPlugin extends FeedPlugin implements FeedPluginInterface {
  const SHORT_CODE = "facebook";

  /** @var Facebook */
  protected $facebook;

  /** @var string */
  protected $pageId = 'projecttcbl';

  /** @var int */
  protected $feed_limit = 5;

  /**
   * FacebookFeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = []) {
    $this->feed_source = self::SHORT_CODE;

    parent::__construct($options);

    $facebookConfig = [
      'app_id' => $options['app_id'],
      'app_secret' => $options['app_secret'],
      'default_graph_version' => $options['default_graph_version'],
    ];
    try {
      $this->facebook = new Facebook($facebookConfig);
    } catch(FacebookSDKException $e) {
      watchdog("TCBL Feed", "Facebook SDK error: " . $e->getMessage(), WATCHDOG_WARNING);
    }
  }

  /**
   * @return array
   */
  public function fetchFeeds(): array {
    $feeds = [];

    if ($this->facebook) {
      $response = FALSE;
      try {
        $app = $this->facebook->getApp();
        $token = $app->getAccessToken();
        $this->facebook->setDefaultAccessToken($token);
        $response = $this->facebook->get($this->getPageReadEndpoint());
      } catch(FacebookSDKException $e) {
        //no response
        watchdog(
          "TCBL Feed", "Facebook feed error: " . $e->getMessage(), WATCHDOG_WARNING
        );
      }

      if ($response) {
        $body = $response->getDecodedBody();
        if ($body && isset($body["data"]) && is_array($body["data"])
            && count($body["data"])) {
          $data = $body["data"];
          //dpm($data);

          foreach($data as $item) {

            $name = isset($item["name"]) ? $item["name"] : "";
            $caption = isset($item["caption"]) ? $item["caption"] : "";
            $description = isset($item["description"]) ? $item["description"] : "";
            $message = isset($item["message"]) ? $item["message"] : "";
            $link = isset($item["link"]) ? $item["link"] : "";
            $full_picture = isset($item["full_picture"]) ? $item["full_picture"] : "";
            $from = isset($item["from"]["name"]) ? $item["from"]["name"] : "Unknown";

            if($from == "TCBL") {
              $feedItem = new FeedItem();
              $feedItem->setId($item["id"]);
              $feedItem->setSource($this->feed_source);
              $feedItem->setType($item["type"]);
              $feedItem->setTitle($name);
              $feedItem->setCaption($caption);
              $feedItem->setDescription($description);
              $feedItem->setMessage($message);
              $feedItem->setCreationDate(new \DateTime($item["created_time"]));
              $feedItem->setUrl($link);
              $feedItem->setPostedByName($from);
              $feedItem->setPictureUrl($full_picture);

              array_push($feeds, $feedItem);
            }
          }
        }
      }
    }

    return $feeds;
  }

  /**
   * @return string
   */
  protected function getPageReadEndpoint() {
    $answer = $this->pageId . '/feed?fields=';

    $fields = [
      'id',
      'name',
      'from',
      'type',
      'caption',
      'created_time',
      'description',
      'message',
      'full_picture',
      'link'
    ];

    $answer .= implode(",", $fields);

    //limit
    $answer .= '&limit=' . $this->feed_limit;

    return $answer;
  }
}

