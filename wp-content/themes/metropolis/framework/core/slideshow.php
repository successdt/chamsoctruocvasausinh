<?php

/**
 * Slideshow class
 *
 **/
class Slideshow
{
	
	/**
	 * Slideshow type
	 *
	 * @var string
	 **/
	private $type;
	
	/**
	 * How many slides the slideshow has
	 *
	 * @var integer
	 **/
	private $num_slides;
	
	/**
	 * Slideshow timeout
	 *
	 * @var integer
	 **/
	public $timeout;
	
	/**
	 * Slideshow transition effect
	 *
	 * @var integer
	 **/
	public $effect;
	
	/**
	 * The slides
	 *
	 * @var array
	 **/
	public $slides;
	
	/**
	 * The slide's width
	 *
	 * @var integer
	 **/
	private $slideWidth;
	
	/**
	 * The slide's height
	 *
	 * @var integer
	 **/
	private $slideHeight;

	/**
	 * True if using TimThumb, false if using custom image sizes
	 *
	 * @var boolean
	 **/
	private $resize;

	/**
	 * The custom image size
	 *
	 * @var string
	 **/
	private $size;

	/**
	 * Constructor
	 */
	public function Slideshow($type, $n, $timeout, $effect, $dimension) {
		$this->type = $type;
		$this->num_slides = !empty($n) ? $n : 999;
		$this->timeout = !empty($timeout) ? $timeout : 6000;
		$this->effect = !empty($effect) ? $effect : "fade";

		if(is_array($dimension)) {
			// Using TimThumb
			$this->slideWidth = $dimension[0];
			$this->slideHeight = $dimension[1];
			$this->resize = true;
		} else {
			// Using WP custom image sizes
			$this->size = $dimension;
			$this->resize = false;
		}

		$this->slides = $this->getSlides();
	}
	
	/**
	 * Retrieves the slides
	 *
	 * @return array The slides
	 **/
	public function getSlides()
	{
		$slides = array();
		switch($this->type) {
			case 'custom':
				$slides = $this->getCustomSlides();
				break;
			default:
				$slides = $this->getPostSlides();
				break;
		}
		
		return $slides;
	}

	/**
	 * Checks if the slideshow has slides to show
	 *
	 * @return boolean
	 **/
	public function hasSlides()
	{
		return !empty($this->slides);
	}
	
	/**
	 * Retrieves the slides from the duplicable table
	 *
	 * @return array
	 **/
	private function getCustomSlides()
	{
		$slides = array();
		
		$items = thb_get_duplicable(SLIDESHOW, null, $this->num_slides);
		foreach($items as $item) {
			$slide = new stdClass;
			$slide->src = $item['src'];

			if($this->resize)
				$slide->resizedSrc = $this->resizeSlide($slide->src);
			else
				$slide->resizedSrc = $this->getResizedAttachment($slide->src, $this->size);

			$slide->url = $item['url'];
			$slide->title = $item['title'];
			$slide->caption = $item['caption'];
			$slide->type = $item['subtype'];
			
			$slides[] = $slide;
		}
		
		return $slides;
	}
	
	/**
	 * Retrieves the slides from the duplicable table
	 *
	 * @return array
	 **/
	private function getPostSlides()
	{
		$slides = array();
		
		$items = thb_get_posts($this->type, array(
			"posts_per_page" => 99,
			"paged" => 1,
			"page" => 1
		));

		$i=0;
		while($items->have_posts() && $i < $this->num_slides) {
			$items->the_post();
			$id = get_the_ID();

			// Slide media
			$video = thb_get_post_meta($id, "_video_url");
			$thumb = thb_get_thumbnail($id);

			$type = "picture";
			$url = get_permalink($id);

			if( !empty($video) ) {
				$type = "video";
				$url = $video;
				$thumb = $video;
			}

			if( !empty($thumb) ) {
				$slide = new stdClass;
				$slide->src = $thumb;
				
				if($this->resize)
					$slide->resizedSrc = $this->resizeSlide($slide->src);
				else
					$slide->resizedSrc = $this->getResizedAttachment($slide->src, $this->size);
				
				$slide->url = $url;
				$slide->title = get_the_title();
				$slide->caption = get_the_excerpt();
				$slide->type = $type;
				
				$slides[] = $slide;
				$i++;
			}
		}
		
		return $slides;
	}
	
	/**
	 * Resizes the slide
	 *
	 * @param string The slide's URL
	 * @return string The resized URL
	 **/
	private function resizeSlide($url)
	{
		return thb_resize($url, $this->slideWidth, $this->slideHeight);
	}

	/**
	 * Gets the resized image
	 *
	 * @param string The slide's URL
	 * @return string The resized image URL
	 **/
	private function getResizedAttachment($url, $size)
	{
		$id = get_attachment_id($url);
		$image = wp_get_attachment_image_src($id, $size);
		return $image[0];
	}
	
} // END class Slideshow

/**
 * Gets the code of a YouTube/Vimeo video
 *
 * @param string $url The URL of the video.
 * @return string
 **/
/*
function getVideoCode( $url ) {
	$tokens = parse_url($url);	
	$code = "";
	if(isset($tokens['query'])) {
		$tokens['query'] = html_entity_decode($tokens['query']);
		$tokens['query'] = str_replace("v=", "", $tokens['query']);

		$pos = strpos($tokens['query'], "&");
		if ($pos !== false) {
		    $tokens['query'] = substr_replace($tokens['query'], "?", $pos, 1);
		}

		$code = $tokens['query'];
	} else {
		$code = trim($tokens['path'], "/");
	}

	return $code;
}
*/
/**
 * Gets the code of a YouTube/Vimeo video
 */
function getVideoCode($url) {
	$tokens = parse_url($url);	
	$code = "";
	if(isset($tokens['query'])) {
		$params = parseQueryString($tokens['query']);
		if(isset($params['v']))
			$code = $params['v'];
	} else {
		$code = trim($tokens['path'], "/");
	}

	return $code;
}

/**
 * Gets the video's thumbnail.
 *
 * @param string $video The URL of the video.
 * @param string $key The key of the video's thumbnail.
 * @return string
 **/
function getVideoThumbnail( $video, $key="" ) {
	$thumbnail = "";
	$video_code = getVideoCode($video);

	if(is_vimeo($video)) {
		$url = "http://vimeo.com/api/v2/video/{$video_code}.php";

		$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        $head = unserialize(curl_exec($ch)); 
        curl_close($ch);

        $thumbnail = $head[0][$key];
	}
	if(is_youtube($video)) {

		// if( strpos($video_code, "?") !== false ) {
		// 	$video_code = explode("?", $video_code);
		// 	$video_code = $video_code[0];
		// }

		$thumbnail = "http://img.youtube.com/vi/{$video_code}/hqdefault.jpg";
	}

	return $thumbnail;
}

/**
 * Checks if the element is a video.
 *
 * @param string $video The URL of the video.
 * @return boolean
 **/
function is_video( $video ) {
	return is_youtube($video) || is_vimeo($video);
}

/**
 * Checks if the video comes from YouTube.
 *
 * @param string $video The URL of the video.
 * @return boolean
 **/
function is_youtube( $video ) {
	return strpos($video, "youtu") !== false;
}

/**
 * Checks if the video comes from Vimeo.
 *
 * @param string $video The URL of the video.
 * @return boolean
 **/
function is_vimeo($video) {
	return strpos($video, "vimeo") !== false;
}