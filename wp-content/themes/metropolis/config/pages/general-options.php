<?php
/*
	Description: Theme option page.
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

$terms = get_terms("types");

$terms_options = array();
$terms_options[0] = "All works";

if( !is_object($terms) ) {
	foreach($terms as $term) {
		$terms_options[$term->term_id] = $term->name;
	}
}

$sidebars = get_sidebars_for_select();

$select_pages[0] = "&mdash; Dynamic home page";
$theme_pages = thb_get_posts('page', array('orderby' => 'id', 'order' => 'desc', 'posts_per_page' => 999));
$theme_pages_array = adminpage::prepare_for_select($theme_pages);
foreach( $theme_pages_array as $k => $v ) {
	$select_pages[$k] = $v;
}

$patterns = getFiles(PATTERNS);
$patterns_options = array();
$patterns_options["0"] = "No pattern";
foreach($patterns as $pattern)
	$patterns_options[PATTERNSURL . "/" . $pattern] = normalizeFileName($pattern);
$patterns_options["custom"] = "Choose your own!";

// SECTIONS ===================================================================

$sections = array(
	"General" => array(
		"fields" => array(
			array( 
				"name" => "Logo",
				"desc" => "Upload an image to be used as a logo for your site, or paste its URL. If this field is left empty, the default Shutter logo will be used.",
				"key" => "_logo_url",
				"type" => "upload",
				"std" => ""
			),
			array( 
				"name" => "Logo position",
				"desc" => "",
				"key" => "_logo_position",
				"type" => "select",
				"options" => array(
					"left" => "Left",
					"center" => "Center",
					"right" => "Right"
				),
				"std" => "left"
			),
			array( 
				"name" => "Favicon URL",
				"desc" => "Paste here the URL of your custom favicon.",
				"key" => "_favicon",
				"type" => "text",
				"std" => ""
			),
			array( 
				"name" => "Apple Touch Icon",
				"desc" => "Paste here the URL of your custom Apple Touch Icon.",
				"key" => "_apple_touch_icon",
				"type" => "text",
				"std" => ""
			),
			array( 
				"name" => "Login image",
				"desc" => "Upload an image to be used as a login logo for your site, or paste its URL. If this field is left empty, the default WordPress login logo will be used.<br><br>Keep in mind that the default dimensions of the image are <code>326&times;67</code>.",
				"key" => "_login_url",
				"type" => "upload",
				"std" => ""
			),
			array( 
				"name" => "Enable the top menu bar",
				"desc" => "",
				"key" => "_top_menu_bar",
				"type" => "select",
				"options" => array(
					"1" => "Yes",
					"0" => "No"
				),
				"std" => "1"
			),
			array(
				"name" => "Slides number",
				"desc" => "Choose how many slides appear in individual posts/works/pages.",
				"key" => "_slideshow_slide_number",
				"type" => "number",
				"std" => "5",
			),
			array( 
				"name" => "Insert here your copyright text (if any)",
				"desc" => "The copyright text will be displayed at the bottom of the site (Note: accepts basic HTML).",
				"key" => "_copyright",
				"type" => "text",
				"std" => ""
			),
			array( 
				"name" => "Alternate RSS feed URL",
				"desc" => "If you want to use a custom feed service, like Feedburner or others, enter your preferred RSS feed URL. Otherwise the default WordPress RSS feed will be used.",
				"key" => "_feed",
				"type" => "text",
				"std" => ""
			),
			array( 
				"name" => "Google Analytics tracking code",
				"desc" => "Paste your Google Analytics code here to enable the stat tracking for this site.",
				"key" => "_analytics",
				"type" => "textareacode",
				"rows" => 4,
				"std" => ""
			)
		)	
	),
	"Home page" => array(
		"fields" => array(
			array( 
				"name" => "Front page displays",
				"desc" => "",
				"key" => "_page_on_front",
				"type" => "select",
				"options" => $select_pages,
				"onchange" => array(
					"0" => "_slideshow_activation"
				),
				"std" => "0"
			),
			array( 
				"name" => "Display a slideshow in the front page",
				"desc" => "Selecting 'Yes' will display the slideshow in the front page.",
				"key" => "_slideshow_activation",
				"type" => "select",
				"options" => array(
					0 => "No",
					1 => "Yes"
				),
				"onchange" => array(
					"1" => "_slideshow_el"
				),
				"std" => "0"
			),
			array( 
				"name" => "Slideshow elements",
				"desc" => "Choose from the 'Slideshow' custom post elements, your latest posts from the blog, or your latest works.",
				"key" => "_slideshow_el",
				"type" => "select",
				"options" => array(
					"custom" => "Slides",
					"post" => "Latest posts from the blog",
					"works" => "Latest works"
				),
				"onchange" => array(
					"post" => "_slideshow_el_num",
					"works" => "_slideshow_el_num"
				),
				"std" => "custom"
			),
			array(
				"name" => "How many elements",
				"desc" => "Choose how many elements will be displayed in the slideshow; if left blank, defaults to 3.<br />Note: Keep in mind that the slideshow will take into account only posts/works with featured image attached.",
				"key" => "_slideshow_el_num",
				"type" => "number",
				"std" => "3",
				"parameters" => array(
					"min" => 1
				)
			),
		)
	),
	"Slideshow" => array(
		"fields" => array(
			array(
				"name" => "Slideshow appearance",
				"desc" => "",
				"key" => "_style_slideshow_appearance",
				"type" => "select",
				"onchange" => array(
					"extended" => "_style_slide_box_caption_height"
				),
				"options" => array (
					"extended" => "Extended",
					"boxed" => "Boxed"
				),
				"std" => "extended"
			),
			array(
				"name" => "Slideshow height",
				"desc" => "",
				"key" => "_style_slideshow_height",
				"type" => "number",
				"std" => "700",
				"parameters" => array(
					"min" => 0,
					"step" => 1
				)
			),
			array(
				"name" => "Slide caption height",
				"desc" => "",
				"key" => "_style_slide_box_caption_height",
				"type" => "number",
				"std" => "410",
				"parameters" => array(
					"min" => 60,
					"step" => 1
				)
			), 
			array(
				"name" => "Delay <em>(seconds)</em>",
				"desc" => "Delay between slides expressed in seconds; if left blank, defaults to 6s.",
				"key" => "_slideshow_timeout",
				"type" => "number",
				"std" => "6",
				"parameters" => array(
					"min" => 1,
					"step" => "0.5"
				)
			),
			array(
				"name" => "Transition speed <em>(seconds)</em>",
				"desc" => "The transition speed between slides expressed in seconds; if left blank, defaults to 0.25s.",
				"key" => "_slideshow_transition_speed",
				"type" => "number",
				"std" => "0.25",
				"parameters" => array(
					"min" => "0.25",
					"step" => "0.25"
				)
			),
			array(
				"name" => "Effect",
				"desc" => "Choose the sliding effect for the slideshow.",
				"key" => "_slideshow_effects",
				"type" => "select",
				"options" => array(
					"fade" => "Fade",
					"scrollUp" => "Scroll up",
					"scrollDown" => "Scroll down",
					"scrollLeft" => "Scroll left",
					"scrollRight" => "Scroll right",
					"wipe" => "Wipe",
					"uncover" => "Uncover"
				),
				"std" => "fade",
			),
			array( 
				"name" => "Overlay pattern",
				"desc" => "Choose a pattern to be used as a slideshow overlay.",
				"key" => "_background_pattern_overlay",
				"type" => "select",
				"options" => $patterns_options,
				"onchange" => array(
					"custom" => "_custom_pattern,_custom_pattern_repeat,_custom_pattern_position"
				),
				"std" => "0"
			),
			array( 
				"name" => "Pattern",
				"desc" => "Upload an image to be used as a pattern.",
				"key" => "_custom_pattern",
				"type" => "upload",
				"std" => ""
			),
			array( 
				"name" => "Pattern repeat",
				"desc" => "Choose the repeat sequence of your pattern.",
				"key" => "_custom_pattern_repeat",
				"type" => "select",
				"options" => array(
					"repeat" => "Repeat",
					"repeat-x" => "Repeat horizontally",
					"repeat-y" => "Repeat vertically",
					"no-repeat" => "No repeat"
				),
				"std" => ""
			),
			array( 
				"name" => "Pattern position",
				"desc" => "Choose the starting position of your pattern.",
				"key" => "_custom_pattern_position",
				"type" => "select",
				"options" => array(
					"top left" => "Top left",
					"top right" => "Top right",
					"bottom left" => "Bottom left",
					"bottom right" => "Bottom right",
					"center left" => "Center left",
					"center right" => "Center right",
					"center center" => "Center"
				),
				"std" => ""
			),
			array(
				"name" => "Caption",
				"desc" => "",
				"key" => "",
				"type" => "heading"
			),
			array(
				"name" => "Effect",
				"desc" => "Choose the effect for the caption texts.",
				"key" => "_slideshow_caption_effects",
				"type" => "select",
				"options" => array(
					"fade" => "Fade",
					"zoom" => "Zoom",
					"rotary" => "Rotary",
					"fastslide" => "Fast slide in"
				),
				"std" => "fade",
			),
			array(
				"name" => "Style",
				"desc" => "Choose the style for your caption box.",
				"key" => "_slideshow_caption_style",
				"type" => "select",
				"options" => array(
					"standard" => "Standard",
					"boxed" => "Boxed full width",
					"boxed left" => "Boxed left",
					"boxed right" => "Boxed right",
					"boxed extended left" => "Boxed extended left",
					"boxed extended right" => "Boxed extended right"
				),
				"std" => "standard"
			)
		)
	),
	"Sidebars" => array(
		"fields" => array(
			array( 
				"name" => "What is the sidebar global position?",
				"desc" => "The sidebar globally appears by default on Left or Right, you can override this setting for a new page using the proper template.",
				"key" => "_sidebar_position",
				"type" => "select",
				"options" => array (
					"right" => "Right",
					"left" => "Left"
				),
				"std" => "right"
			),
			array(
				"name" => "Widget areas",
				"desc" => "",
				"key" => "",
				"type" => "heading"
			),
			array(
				"name" => "Top area layout",
				"desc" => "Choose your top area layout. E.g. selecting '2 columns' will create two distinct widget areas named 'Top area column #'",
				"key" => "_top_sidebar",
				"type" => "stripe",
				"std" => ""
			),
			array(
				"name" => "Footer area layout",
				"desc" => "Choose your footer area layout. E.g. selecting '2 columns' will create two distinct widget areas named 'Footer area column #'",
				"key" => "_footer",
				"type" => "stripe",
				"std" => ""
			),
			array(
				"name" => "Post types and pages sidebars",
				"desc" => "",
				"key" => "",
				"type" => "heading"
			),
			array(
				"name" => "Blog",
				"desc" => "Choose your default sidebar for individual blog posts and blog pages.",
				"key" => "_sidebar_post",
				"type" => "select",
				"options" => $sidebars,
				"std" => ""
			),
			array(
				"name" => "Works",
				"desc" => "Choose your default sidebar for works page.",
				"key" => "_sidebar_works",
				"type" => "select",
				"options" => $sidebars,
				"std" => ""
			),
			array(
				"name" => "Testimonials",
				"desc" => "Choose your default sidebar for testimonials page.",
				"key" => "_sidebar_testimonials",
				"type" => "select",
				"options" => $sidebars,
				"std" => ""
			),
			array(
				"name" => "<strong>Archive</strong> and <strong>Search</strong> pages",
				"desc" => "Choose your Archive and Search pages sidebar.",
				"key" => "_sidebar_archivesearch_id",
				"type" => "select",
				"options" => $sidebars,
				"std" => ""
			)
		)
	),
	"Blog" => array(
		"fields" => array(
			array( 
				"name" => "Enable a related posts section on single post",
				"desc" => "Selecting 'Yes' automatically creates a 'related posts' section at the bottom of the single post page.",
				"key" => "_post_related",
				"type" => "select",
				"options" => array (
					"1" => "Yes",
					"0" => "No"
				),
				"std" => "1"
			),
			array( 
				"name" => "Enable the navigation between posts",
				"desc" => "Selecting 'Yes' will show the posts navigation.",
				"key" => "_post_shownav",
				"type" => "select",
				"options" => array (
					"1" => "Yes",
					"0" => "No"
				),
				"std" => "1"
			)
		)
	),
	"Portfolio" => array(
		"fields" => array(
			array(
				"name" => "Works per page",
				"desc" => "Eg. if you write 4, and you have 5 works, the 5th work will appear in page 2. Defaults to 9.",
				"key" => "_works_per_page",
				"type" => "number",
				"std" => "9"
			),
			array( 
				"name" => "Works order",
				"desc" => "",
				"key" => "_works_order",
				"type" => "select",
				"options" => array (
					"date" => "Date",
					"title" => "Alphabetic"
				),
				"std" => "date"
			),
			array( 
				"name" => "Default works filter category",
				"desc" => "Choose your default category for the portfolio page.",
				"key" => "_works_default_filter",
				"type" => "select",
				"options" => $terms_options,
				"std" => "0"
			),
			array(
				"name" => "Single project page",
				"desc" => "",
				"key" => "",
				"type" => "heading"
			),
			array(
				"name" => "URL slug",
				"desc" => "URL slug for Portfolio items. Defaults to \"works\".",
				"key" => "_works_slug",
				"type" => "text",
				"std" => "works"
			),
			array( 
				"name" => "Enable comments",
				"desc" => "Selecting 'Yes' will enable the comments functionality.",
				"key" => "_works_comments",
				"type" => "select",
				"options" => array (
					"1" => "Yes",
					"0" => "No"
				),
				"std" => "0"
			),
			array( 
				"name" => "Enable a related works section",
				"desc" => "Selecting 'Yes' automatically creates a 'related works' section at the bottom of the single work page.",
				"key" => "_work_related",
				"type" => "select",
				"options" => array (
					"1" => "Yes",
					"0" => "No"
				),
				"std" => "1"
			),
			array( 
				"name" => "Disable navigation between works",
				"desc" => "Selecting 'Yes' will hide the works navigation.",
				"key" => "_work_hidenav",
				"type" => "select",
				"options" => array (
					"1" => "Yes",
					"0" => "No"
				),
				"std" => "0"
			)
		)
	),
	"Contact" => array(
		"fields" => array(
			array( 
				"name" => "Address",
				"desc" => "",
				"key" => "_contact_address",
				"type" => "textarea",
				"rows" => 5,
				"std" => ""
			),
			array(
				"name" => "Phone number",
				"desc" => "",
				"key" => "_contact_phone",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Mobile phone number",
				"desc" => "",
				"key" => "_contact_mobile",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Fax number",
				"desc" => "",
				"key" => "_contact_fax",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Email address",
				"desc" => "Insert here your email address to be used by the contact form and the contact information widget.",
				"key" => "_contact_email",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Secondary email address",
				"desc" => "Insert here another email address if you don't want emails to be sent to the email address specified above.<br />If left blank, the contact form will use the email address filed above; if this is blank as well, it will take the WordPress installation administrator's email.",
				"key" => "_contact_form_email",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Latitude and Longitude",
				"desc" => "Insert the latitude and longitude of your address for Google Maps generation (eg. <code>44.422, 8.937</code>).",
				"key" => "_contact_lat_long",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Google Map zoom",
				"desc" => "A reasonable value ranges from 6 to 16; if left blank, the default value will be 10.",
				"key" => "_gmap_zoom",
				"type" => "number",
				"std" => "10"
			)
		)
	),
	"Social" => array(
		"fields" => array(
			array( 
				"name" => "Twitter",
				"desc" => "Enter your Twitter username.",
				"key" => "_social_twitter",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Facebook",
				"desc" => "Enter your Facebook username.",
				"key" => "_social_facebook",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Google+",
				"desc" => "Enter your Google+ ID number (eg. 106225649190118878439).",
				"key" => "_social_googleplus",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Flickr",
				"desc" => "Enter your flickr username.",
				"key" => "_social_flickr",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Forrst",
				"desc" => "Enter your Forrst username.",
				"key" => "_social_forrst",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Dribbble",
				"desc" => "Enter your dribbble username.",
				"key" => "_social_dribbble",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Delicious",
				"desc" => "Enter your Delicious username.",
				"key" => "_social_delicious",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Youtube",
				"desc" => "Enter your Youtube username.",
				"key" => "_social_youtube",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Vimeo",
				"desc" => "Enter your Vimeo username.",
				"key" => "_social_vimeo",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Digg",
				"desc" => "Enter your Digg username.",
				"key" => "_social_digg",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "LinkedIn",
				"desc" => "Enter your LinkedIn username.",
				"key" => "_social_linkedin",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Picasa",
				"desc" => "Enter your Picasa username.",
				"key" => "_social_picasa",
				"type" => "text",
				"std" => ""
			),
			array(
				"name" => "Pinterest",
				"desc" => "Enter your Pinterest username.",
				"key" => "_social_pinterest",
				"type" => "text",
				"std" => ""
			)
		)
	),
	"Labels" => array(
		"fields" => array(
			array( 
				"name" => "Comments heading",
				"desc" => "Default: 'Join the discussion'.",
				"key" => "_label_comments_heading",
				"type" => "text",
				"std" => "Join the discussion"
			),
			array( 
				"name" => "'Read' button",
				"desc" => "Default: 'Read'.",
				"key" => "_label_read",
				"type" => "text",
				"std" => "Read"
			),
			array( 
				"name" => "Related posts",
				"desc" => "Default: 'Did you like what you read? You might also like:'.",
				"key" => "_label_related_posts",
				"type" => "text",
				"std" => "Did you like what you read? You might also like:"
			)
		)
	),
	"SEO" => array(
		"fields" => array(
			array(
				"name" => "Site author",
				"desc" => "",
				"key"  => "_site_author",
				"type" => "text",
				"std"  => ""
			),
			array(
				"name" => "Site description",
				"desc" => "",
				"key"  => "_site_description",
				"type" => "textarea",
				"std"  => "",
				"rows" => 3
			),
			array(
				"name" => "Keywords",
				"desc" => "",
				"key"  => "_keywords",
				"type" => "textarea",
				"std"  => "",
				"rows" => 3
			),
			array(
				"name" => "Google site verification",
				"desc" => "",
				"key"  => "_google_verification",
				"type" => "text",
				"std"  => ""
			)
		)
	)
);

$ThemePage = new optionpage($sections);
$message = $ThemePage->save();

$ThemePage->setMessage($message);
$ThemePage->render();