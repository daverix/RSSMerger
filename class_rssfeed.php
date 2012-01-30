<?php
/**
 * This class has methods for making a RSS 2.0 feed.
 * @author David Laurell <david.laurell@gmail.com>
 */
class RSSFeed {
    private $xml;
    
    /**
     * Construct a RSS feed
     * @param $title the title of the feed
     * @param $link link to the website where you can find the RSS feed
     * @param $description a description of the RSS feed
     * @param $rsslink the link to this RSS feed
     */
    public function __construct($title, $link, $description, $rsslink) {
$template = <<<END
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
</channel>
</rss>
END;
        
        $this->xml = new SimpleXMLElement($template);
        $atomlink = $this->xml->channel->addChild("atom:link","","http://www.w3.org/2005/Atom");
        $atomlink->addAttribute("href",$rsslink);
        $atomlink->addAttribute("rel","self");
        $atomlink->addAttribute("type","application/rss+xml");
        
        $this->xml->channel->addChild("title",$title);
        $this->xml->channel->addChild("link",$link);
        $this->xml->channel->addChild("description",$description);        
    }
    /**
     * Set the language of the RSS feed
     * @param $lang the language of the RSS feed
     */
    public function setLanguage($lang) {
        $this->xml->channel->addChild("language",$lang);
    }
    /**
     * Adds a picture to the RSS feed
     * @param $url URL to the image
     * @param $title The image title. Usually same as the RSS feed's title
     * @param $link Where the image should link to. Usually same as the RSS feed's link
     */
	public function setImage($url, $title, $link) {
		$image = $this->xml->channel->addChild("image");
		$image->addChild("url",$url);
		$image->addChild("title",$title);
		$image->addChild("link",$link);
	}
	/**
	 * Add a item to the RSS feed
	 * @param $title The title of the RSS feed
	 * @param $link Link to the item's url
	 * @param $description The description of the item
	 * @param $author The author who wrote this item
	 * @param $guid Unique ID for this post
	 * @param $timestamp Unix timestamp for making a date
	 */
	public function addItem($title, $link, $description, $author, $guid, $timestamp) {
	    $item = $this->xml->channel->addChild("item");
	    $item->addChild("title",$title);
	    $item->addChild("description",$description);
	    $item->addChild("link",$link);
	    $item->addChild("guid",$guid);
	    $item->addChild("author",$author);
	    $item->addChild("pubDate",date(DATE_RSS,intval($timestamp)));
	}
	/**
	 * Displays the RSS feed 
	 */
	public function displayXML() {
	    header('Content-type: application/rss+xml; charset=utf-8');
	    echo $this->xml->asXML();
	    exit;
	}
}

?>