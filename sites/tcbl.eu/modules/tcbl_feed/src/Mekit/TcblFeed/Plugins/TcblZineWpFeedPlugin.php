<?php
/**
 * Created by Adam Jakab.
 * Date: 02/02/18
 * Time: 12.31
 */

namespace Mekit\TcblFeed\Plugins;

use Mekit\TcblFeed\FeedItem;

class TcblZineWpFeedPlugin extends FeedPlugin implements FeedPluginInterface {

  /** @var string */
  protected $rssFeedUrl = "https://zine.tcbl.eu/feed";

  /**
   * TcblZineWpFeedPlugin constructor.
   *
   * @param array $options
   */
  public function __construct(array $options = []) {
    $this->feed_source = "tcbl_zine";

    parent::__construct($options);
  }

  /**
   * @return array
   */
  public function fetchFeeds(): array {
    $feeds = [];

    $data = $this->fetchRssXmlAndConvertToObject($this->rssFeedUrl);
    //dpm($data, "ZINE DATA");

    if ($data && isset($data->channel)) {
      if(isset($data->channel->item) && is_array($data->channel->item)) {

        $id = 0;
        /** @var \stdClass $item */
        foreach($data->channel->item as $item) {
          $id++;
          //print_r($item);

          $feedItem = new FeedItem();
          $feedItem->setId($this->feed_source . "_" . $id);
          $feedItem->setSource($this->feed_source);
          $feedItem->setType("post");
          $feedItem->setTitle($item->title);
          $feedItem->setDescription($item->description);
          $feedItem->setCreationDate(new \DateTime($item->pubDate));
          $feedItem->setUrl($item->link);
          //$feedItem->setPostedByName($item->author);
          if(isset($item->enclosure->url)) {
            $feedItem->setPictureUrl($item->enclosure->url);
          }

          array_push($feeds, $feedItem);
        }
      }
    }

    return $feeds;
  }

  /**
   * Temporay Xml fix to:
   * 1) strip html from description
   * 2) add image_url
   *
   * @param \SimpleXMLElement $el
   *
   * @return \SimpleXMLElement
   */
  protected function fixRssXmlRecursively(\SimpleXMLElement $el) {

    if ($el->count()) {
      $strippedDescription = null;
      /** @var \SimpleXMLElement $child */
      foreach($el->children() as $child) {
        if($child->getName() == "description") {
          $strippedDescription = trim(strip_tags($child->__toString()));
        }

        $child = $this->fixRssXmlRecursively($child);
      }

      if(!is_null($strippedDescription)) {
        unset($el->description);
        $el->addChild("description", $strippedDescription);
      }
    }

    if($media = $el->children( 'media', true )) {
      $mediaContentAttributes = $media->content->attributes();
      $mediaUrl = $mediaContentAttributes->url->__toString();
      $enclosure = $el->addChild("enclosure");
      $enclosure->addAttribute("url", $mediaUrl);
    }



    return $el;
  }

}

