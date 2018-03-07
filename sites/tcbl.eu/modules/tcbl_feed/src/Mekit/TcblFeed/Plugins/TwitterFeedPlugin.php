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
    $this->feed_source = "twitter";

    parent::__construct($options);

    $twitterConfig = [
      "consumer_key"            => "05rhm0AJq1Wcl8VdVR1EKb1qY",
      "consumer_secret"         => "ozj7VwhS2GO3anJTpS82OWUtrEEzx7uwSKCh7bWEhIoVA3swl3",
      "access_token"            => "776749216442056704-9hZR2zniP7UTabNDtOFdFowoPDqhMpj",
      "access_token_secret"     => "mqx0lSHqvYNKErjd1cXRSzl8M9XJ05Jz57bBEWCZAEhQE",
    ];

    $this->twitter = new TwitterOAuth(
      $twitterConfig["consumer_key"],
      $twitterConfig["consumer_secret"],
      $twitterConfig["access_token"],
      $twitterConfig["access_token_secret"]
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
          "Feed", "Twitter feed error: " . $e->getMessage(), WATCHDOG_WARNING);
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

