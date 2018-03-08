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
  protected $pageId = 'tcblproject';

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

  /**
   * @return array
   */
  public function fetchFeeds(): array {
    $feeds = [];

    if($this->instagram) {
      $medias = FALSE;
      try{
        $medias = $this->instagram->getMedias($this->pageId, $this->feed_limit);
      } catch (InstagramException $e) {
        watchdog(
          "TCBL Feed", "Instagram feed error: " . $e->getMessage(), WATCHDOG_WARNING);
      }

      if($medias) {

        /** @var Media $media */
        foreach($medias as $media) {

          $pictureUrl = $media->getImageLowResolutionUrl();
          $squareThumbs = $media->getSquareThumbnailsUrl();
          if(isset($squareThumbs[1])){
            $pictureUrl = $squareThumbs[1];
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

