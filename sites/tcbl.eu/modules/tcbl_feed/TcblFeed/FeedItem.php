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
 * https://www.facebook.com/projecttcbl/
 * https://developers.facebook.com/tools/explorer/145634995501895/?method=GET&path=projecttcbl%2Ffeed%3Ffields%3Dtype%2Ccaption%2Cmessage%2Cdescription%2Clink%2Cname%2Cobject_id%2Cpicture%2Cfrom%2Ccreated_time&version=v2.11
 * https://developers.facebook.com/docs/graph-api/reference/v2.11/post
 * https://developers.facebook.com/docs/graph-api/reference/v2.11/page/feed
 * https://stackoverflow.com/questions/15603434/get-facebook-public-posts-from-a-page-to-a-php-array
 *
 *
 * FB RESPONSE:
 * //projecttcbl/feed?fields=type,caption,message,description,link,name,object_id,picture,from,created_time
 *
 * {
    "type": "link",
    "caption": "bloomberg.com",
    "message": "Now that cycle is breaking down. Fashion trends are accelerating, new clothes are becoming as cheap as used ones, and poor countries are turning their backs on the secondhand trade. Without significant changes in the way that clothes are made and marketed, this could add up to an environmental disaster in the making.",
    "description": "A once-virtuous cycle is breaking down. What now?",
    "link": "https://www.bloomberg.com/view/articles/2018-01-15/no-one-wants-your-used-clothes-anymore",
    "name": "No One Wants Your Used Clothes Anymore",
    "picture": "https://external.xx.fbcdn.net/safe_image.php?d=AQBnDx58fu3mLoQN&w=130&h=130&url=https%3A%2F%2Fassets.bwbx.io%2Fimages%2Fusers%2FiqjWHBFdfxIU%2Fibqz2cs.OjmA%2Fv0%2F1200x799.jpg&cfs=1&sx=249&sy=0&sw=799&sh=799&_nc_hash=AQDDBvzGAY1kBayu",
    "from": {
    "name": "TCBL",
    "id": "124666714540921"
    },
    "created_time": "2018-01-24T13:07:22+0000",
    "id": "124666714540921_576831392657782"
    },
 *
 * @package TcblFeed
 */
class FeedItem {
  /**
   * @var string - id of the post
   */
  protected $id;

  /**
   * @var string - facebook|twitter|etc...
   */
  protected $source;

  /**
   * @var string - post|link|status|photo|video
   */
  protected $type;

  /**
   * @var string - the title/name of the post
   */
  protected $title;

  /**
   * @var string - the description
   */
  protected $description;

  /**
   * @var string - the caption
   */
  protected $caption;

  /**
   * @var string - the message
   */
  protected $message;

  /**
   * @var string - urls to the post picture
   */
  protected $picture_url;

  /**
   * @var string - link to the post
   */
  protected $url;

  /**
   * @var string - the name of the account who posted
   */
  protected $posted_by_name;

  /**
   * @var string - the image of the account who posted
   */
  protected $posted_by_picture_url;

  /**
   * @var \DateTime - the creation date/time
   */
  protected $creation_date;

  /**
   * FeedItem constructor.
   */
  public function __construct() {
    $this->setCreationDate(new \DateTime());
  }

  /**
   * @return array
   */
  public function getPropertyArray()
  {
    return get_object_vars($this);
  }

  /**
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * @param string $id
   */
  public function setId(string $id) {
    $this->id = $id;
  }

  /**
   * @return string
   */
  public function getSource(): string {
    return $this->source;
  }

  /**
   * @param string $source
   */
  public function setSource(string $source) {
    $this->source = $source;
  }

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
  public function getDescription(): string {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription(string $description) {
    $this->description = $description;
  }

  /**
   * @return string
   */
  public function getCaption(): string {
    return $this->caption;
  }

  /**
   * @param string $caption
   */
  public function setCaption(string $caption) {
    $this->caption = $caption;
  }

  /**
   * @return string
   */
  public function getMessage(): string {
    return $this->message;
  }

  /**
   * @param string $message
   */
  public function setMessage(string $message) {
    $this->message = $message;
  }

  /**
   * @return string
   */
  public function getPictureUrl(): string {
    return $this->picture_url;
  }

  /**
   * @param string $picture_url
   */
  public function setPictureUrl(string $picture_url) {
    $this->picture_url = $picture_url;
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
  public function getPostedByName(): string {
    return $this->posted_by_name;
  }

  /**
   * @param string $posted_by_name
   */
  public function setPostedByName(string $posted_by_name) {
    $this->posted_by_name = $posted_by_name;
  }

  /**
   * @return string
   */
  public function getPostedByPictureUrl(): string {
    return $this->posted_by_picture_url;
  }

  /**
   * @param string $posted_by_picture_url
   */
  public function setPostedByPictureUrl(string $posted_by_picture_url) {
    $this->posted_by_picture_url = $posted_by_picture_url;
  }

  /**
   * @return \DateTime
   */
  public function getCreationDate(): \DateTime {
    return $this->creation_date;
  }

  /**
   * @param string $format
   * @return string
   */
  public function getFormattedCreationDate($format = 'Y-m-d H:i:s'): string {
    return $this->creation_date->format($format);
  }

  /**
   * @param \DateTime $creation_date
   */
  public function setCreationDate(\DateTime $creation_date) {
    $this->creation_date = $creation_date;
  }
}