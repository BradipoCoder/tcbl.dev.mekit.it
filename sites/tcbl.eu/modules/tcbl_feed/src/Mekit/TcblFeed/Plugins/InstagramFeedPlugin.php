<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 *
 * using Instagram Scraper: https://github.com/postaddictme/instagram-php-scraper
 */

namespace Mekit\TcblFeed\Plugins;

use InstagramScraper\Exception\InstagramException;
use InstagramScraper\Instagram;
use \InstagramScraper\Model\Media;
use Mekit\TcblFeed\FeedItem;

class InstagramFeedPlugin extends FeedPlugin implements FeedPluginInterface {
  const SHORT_CODE = "instagram";

  /** @var Instagram */
  protected $instagram;

  /** @var string */
  protected $pageId = 'tcblfoundation';

  /** @var int */
  protected $feed_limit = 5;

  /**
   * InstagramFeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = []) {
    $this->feed_source = self::SHORT_CODE;

    parent::__construct($options);

    $this->instagram = new Instagram();
  }

  public function fetchFeeds(): array {
    $feeds = [];

    $url = 'https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,timestamp,permalink&limit=5&access_token=IGQVJVeVRGRlBhVUpBb2NfU2F1dDJnREJxdE9ETXB1YXh3VVVWXzFHUjRacEpzeVRXU2NQTEtHZAjZA6M21ERDdueGh4ckxkSktGbl9WRzItV0F0T0VQY2lsWUpFSk9SeVEtYmp1V1VsamNvUWNIVXFfZAwZDZD';
    
    $ch = curl_init();
    // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
    // in most cases, you should set it to true
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_URL, $url);
    // $result = curl_exec($ch);
    // curl_close($ch);
    // $obj = json_decode($result);
    // dpm($obj);

    // $obj = json_decode(file_get_contents($url), true);
    // dpm($obj);

    return $feeds;
  }

  /**
   * @return array
   */
  public function fetchFeedsOld(): array {
    $feeds = [];

    if($this->instagram) {
      $medias = FALSE;
      try{
        $medias = $this->instagram->getMedias($this->pageId, $this->feed_limit);
      } catch (InstagramException $e) {
        watchdog(
          "TCBL Feed", "Instagram feed error: " . $e->getMessage(), array(), WATCHDOG_WARNING);
      }

      if($medias) {

        /** @var Media $media */
        foreach($medias as $media) {

          $pictureUrl = $media->getImageLowResolutionUrl();
          $squareThumbs = $media->getImageHighResolutionUrl();
          if($squareThumbs){
            $pictureUrl = $squareThumbs;
          }

          $owner = $media->getOwner();
          $authorName = $owner->getFullName();
          $authorPicUrl = $owner->getProfilePicUrl();

          $creationDate = new \DateTime();
          $creationDate->setTimestamp($media->getCreatedTime());

          $feedItem = new FeedItem();
          $feedItem->setId($media->getId());
          $feedItem->setSource($this->feed_source);
          $feedItem->setType($media->getType());
          $feedItem->setTitle("");
          $feedItem->setCaption($media->getCaption());
          $feedItem->setDescription("");
          $feedItem->setMessage($media->getCaption());
          $feedItem->setCreationDate($creationDate);
          $feedItem->setUrl($media->getLink());
          $feedItem->setPostedByName($authorName);
          $feedItem->setPostedByPictureUrl($authorPicUrl);
          $feedItem->setPictureUrl($pictureUrl);

          array_push($feeds, $feedItem);

        }
      }

    }

    return $feeds;
  }
}

