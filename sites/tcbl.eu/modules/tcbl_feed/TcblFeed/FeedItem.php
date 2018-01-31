<?php
/**
 * Created by Adam Jakab.
 * Date: 30/01/18
 * Time: 12.25
 */

namespace TcblFeed;

/**
 * Class FeedItem
 *
 * @package TcblFeed
 */
class FeedItem {
  /** @var string */
  protected $type;

  /** @var string */
  protected $url;

  /** @var string */
  protected $title;

  /** @var string */
  protected $content;

  /** @var \DateTime */
  protected $date;

  /**
   * @return string
   */
  public function getType(): string {
    return $this->type;
  }

  /**
   * @param string $type
   */
  public function setType(string $type) {
    $this->type = $type;
  }

  /**
   * @return string
   */
  public function getUrl(): string {
    return $this->url;
  }

  /**
   * @param string $url
   */
  public function setUrl(string $url) {
    $this->url = $url;
  }

  /**
   * @return string
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * @param string $title
   */
  public function setTitle(string $title) {
    $this->title = $title;
  }

  /**
   * @return string
   */
  public function getContent(): string {
    return $this->content;
  }

  /**
   * @param string $content
   */
  public function setContent(string $content) {
    $this->content = $content;
  }

  /**
   * @return \DateTime
   */
  public function getDate(): \DateTime {
    return $this->date;
  }

  /**
   * @param \DateTime $date
   */
  public function setDate(\DateTime $date) {
    $this->date = $date;
  }

}