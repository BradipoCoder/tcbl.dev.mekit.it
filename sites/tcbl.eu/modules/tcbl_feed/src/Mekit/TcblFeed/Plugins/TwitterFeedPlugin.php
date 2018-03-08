<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 *
 * Using Twitter Oauth: https://twitteroauth.com/
 */

namespace Mekit\TcblFeed\Plugins;

use Mekit\TcblFeed\FeedItem;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterFeedPlugin extends FeedPlugin implements FeedPluginInterface {
  const SHORT_CODE = "twitter";

  /** @var TwitterOAuth */
  protected $twitter;

  /** @var string */
  protected $pageId = 'statuses/user_timeline';

  /** @var int */
  protected $feed_limit = 5;

  /**
   * TwitterFeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = []) {
    $this->feed_source = self::SHORT_CODE;

    parent::__construct($options);

    $this->twitter = new TwitterOAuth(
      $options["consumer_key"],
      $options["consumer_secret"],
      $options["access_token"],
      $options["access_token_secret"]
    );
  }

  /**
   * @return array
   */
  public function fetchFeeds(): array {
    $feeds = [];

    if($this->twitter) {

      $tweets = false;
      try {
        $tweets = $this->twitter->get($this->pageId,
                                      [
                                        "count" => $this->feed_limit,
                                        "exclude_replies" => true
                                      ]);
      } catch(\Exception $e) {
        watchdog(
          "TCBL Feed", "Twitter feed error: " . $e->getMessage(), WATCHDOG_WARNING);
      }

      if($tweets) {
        //dpm($tweets);

        /** @var \stdClass $tweet */
        foreach($tweets as $tweet) {

          $message = isset($tweet->text) ? $tweet->text : "";

          $link = "https://twitter.com/tcblproject/status/" . $tweet->id_str;

          $authorName = isset($tweet->user->name) ? $tweet->user->name : "";
          $authorPicUrl = isset($tweet->user->profile_image_url_https) ? $tweet->user->profile_image_url_https : "";

          $feedItem = new FeedItem();
          $feedItem->setId($tweet->id_str);
          $feedItem->setSource($this->feed_source);
          $feedItem->setType("post");
          $feedItem->setTitle("");
          $feedItem->setCaption("");
          $feedItem->setDescription("");
          $feedItem->setMessage($message);
          $feedItem->setCreationDate(new \DateTime($tweet->created_at));
          $feedItem->setUrl($link);
          $feedItem->setPostedByName($authorName);
          $feedItem->setPostedByPictureUrl($authorPicUrl);
          //$feedItem->setPictureUrl($pictureUrl);

          array_push($feeds, $feedItem);
        }
      }
    }

    return $feeds;
  }
}

