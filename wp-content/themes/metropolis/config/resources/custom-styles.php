<?php

/**
 * Setting the right MIME type
 */
header('Content-type: text/css');

// Custom fonts -----------------------------------------------------------------------------------

$fonts = getFonts();
$sections = array(
	"_font_pagetitle",
	"_font_pagesubtitle",
	"_font_text",
	"_font_widgetheadings",
	"_font_topareawidgetheadings",
	"_font_footerareawidgetheadings",
	"_font_slideheading",
	"_font_footertext",
	"_font_menu",
	"_font_submenu"
);

foreach($sections as $section) {
	importGoogleWebFont( thb_get_option($section), $fonts );
}

if( thb_is_debug() ) {
	foreach($sections as $section) {
		$section = THEMEPREFIX . $section;
		if( isset($_GET[$section]) ) {
			importGoogleWebFont( urlencode($_GET[$section]), $fonts );
		}
	}
}

$items = thb_get_duplicable(CUSTOMFONT);
foreach($items as $item) {
	echo "@import url(". $item['url'] . ");\n";
}

// Custom logo ------------------------------------------------------------------------------------

$logo = thb_get_option('_logo_url');
if( !empty($logo) ) {
	$logoinfos = thb_get_image_dimensions($logo);
	echo "\n#logo a { 
		background: url({$logo}) no-repeat;
		width: {$logoinfos->width}px;
		height: {$logoinfos->height}px;
	}";
}

// Slideshow appearance ---------------------------------------------------------------------------

$caption_default_height = 410;
$background_container_height = thb_get_option("_style_slideshow_height");
$slide_box_caption_height = thb_get_option("_style_slide_box_caption_height");
$slideshow_appearance = thb_get_option("_style_slideshow_appearance");
?>

.background_container,
.background_overlay {
	<?php if( $background_container_height == "0" ) : ?>
		bottom: 0;
		position: fixed;
	<?php else : ?>
		height: <?php echo $background_container_height != "" ? $background_container_height : 700; ?>px;
	<?php endif; ?>
}

.slide-box-caption.extended-container {
	<?php if( $slideshow_appearance == "extended" ) : ?>
		min-height: <?php echo $slide_box_caption_height != "" ? $slide_box_caption_height : $caption_default_height; ?>px;
		max-height: <?php echo $slide_box_caption_height != "" ? $slide_box_caption_height : $caption_default_height; ?>px;
	<?php else : ?>
		min-height: <?php echo $background_container_height != "" ? $background_container_height : $caption_default_height; ?>px;
		max-height: <?php echo $background_container_height != "" ? $background_container_height : $caption_default_height; ?>px;
	<?php endif; ?>
}

.controls-container.external {
	width: 100%;
	left: 0;
	right: 0;
	z-index: 100;
	-khtml-opacity: 1;
	-moz-opacity: 1;
	opacity: 1;
	filter: alpha(opacity=100);
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";

	<?php if( $background_container_height != 0 ) : ?>
		top: <?php echo $background_container_height/2; ?>px;
	<?php else : ?>
		top: 50%;
	<?php endif; ?>
}

.controls-container.external .bg-prev,
.controls-container.external .bg-next {
	<?php if( $background_container_height != 0 ) : ?>
		position: absolute;
	<?php else : ?>
		position: fixed;
	<?php endif; ?>
}

.controls-container.external .bg-prev {
	left: 10px;
}

.controls-container.external .bg-next {
	right: 10px;
}

<?php 
	// Custom colors ---------------------------------------------------------------------------- 
	$highlight = "#" . thb_get_option("_main_color");
	$darken5 = darken($highlight, 5);
	$darken10 = darken($highlight, 10);
	$darken20 = darken($highlight, 20);
	$darken22 = darken($highlight, 22);
	$lighten10 = lighten($highlight, 10);
?>

<?php if( $highlight != "#" ) : ?>

	::-webkit-selection {
		<?php cssRule("background-color", $highlight, " !important"); ?>
	}

	::-moz-selection {
		<?php cssRule("background-color", $highlight, " !important"); ?>
	}

	::selection {
		<?php cssRule("background-color", $highlight, " !important"); ?>
	}

	a:hover,
	body #footer a:hover,
	body #footer-sidebar a:hover {
		<?php cssRule("color", $highlight); ?>
	}

	a:active,
	body #footer a:active,
	body #footer-sidebar a:active {
		<?php cssRule("color", $darken20); ?>
	}

	.slide-box-caption.extended-container .slide-overlay .slide-heading a:hover {
		<?php cssRule("color", $highlight); ?>
	}

	#main-nav ul li.menu-item-hover > a,
	#main-nav ul li.current-menu-item > a {
		<?php cssRule("color", $highlight); ?>
		<?php cssRule("border-top-color", $highlight); ?>
	}

	#main-nav ul.sub-menu {
		<?php cssRule("border-top-color", $highlight); ?>
	}

	#main-nav ul.sub-menu li:first-of-type:before {
		<?php cssRule("border-bottom-color", $highlight); ?>
	}

	#main-nav ul.sub-menu li.menu-item-hover > a,
	#main-nav ul.sub-menu li.current-menu-item > a {
		<?php cssRule("color", $highlight); ?>
	}

	.content .page-header:after {
		<?php cssRule("background-color", $highlight); ?>
	}

	.page-nav li a:hover {
		<?php cssRule("color", $highlight); ?>
	}

	.page-nav .wp-pagenavi .current {
		<?php cssRule("background", $highlight); ?>
	}

	.page-nav .wp-pagenavi .page.larger:hover,
	.page-nav .wp-pagenavi .page.smaller:hover {
		<?php cssRule("color", $highlight); ?>
	}

	.page-nav .wp-pagenavi a.nextpostslink:hover {
		<?php cssRule("background", $highlight); ?>
	}

#	.post-gallery .flex-control-nav li a.active {
		<?php cssRule("background-color", $highlight); ?>
	}

	.post-gallery .flex-direction-nav li .prev:hover,
	.post-gallery .flex-direction-nav li .next:hover {
		<?php cssRule("background-color", $highlight); ?>
	}

	.single .post .meta a:hover {
		<?php cssRule("color", $highlight); ?>
	}

	.single .post .meta a:active {
		<?php cssRule("color", $darken20); ?>
	}

	#reply-title:after {
		<?php cssRule("background-color", $highlight); ?>
	}

	#comments li .comment.admin img {
		<?php cssRule("border-bottom-color", $highlight); ?>
	}

	.secondary form input#submit,
	a.btn, input#submit, input[type='submit'], button {
		text-shadow: 0 -1px 0 <?php echo $darken10; ?>;
		border: 1px solid <?php echo $darken10; ?>;
		background-color: <?php echo $darken10; ?>;
		background-repeat: repeat-x;
		background-image: -khtml-gradient(linear, left top, left bottom, from(<?php echo $highlight; ?>), to(<?php echo $darken10; ?>));
		background-image: -moz-linear-gradient(top, <?php echo $highlight; ?>, <?php echo $darken10; ?>);
		background-image: -ms-linear-gradient(top, <?php echo $highlight; ?>, <?php echo $darken10; ?>);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $highlight; ?>), color-stop(100%, <?php echo $darken10; ?>));
		background-image: -webkit-linear-gradient(top, <?php echo $highlight; ?>, <?php echo $darken10; ?>);
		background-image: -o-linear-gradient(top, <?php echo $highlight; ?>, <?php echo $darken10; ?>);
		background-image: linear-gradient(top, <?php echo $highlight; ?>, <?php echo $darken10; ?>);
	}

	.secondary form input#submit:hover,
	a.btn:hover, input#submit:hover, input[type='submit']:hover, button:hover {
		color: #fff;
		background-color: <?php echo $highlight; ?>;
		background-repeat: repeat-x;
		background-image: -khtml-gradient(linear, left top, left bottom, from(<?php echo $lighten10; ?>), to(<?php echo $highlight; ?>));
		background-image: -moz-linear-gradient(top, <?php echo $lighten10; ?>, <?php echo $highlight; ?>);
		background-image: -ms-linear-gradient(top, <?php echo $lighten10; ?>, <?php echo $highlight; ?>);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $lighten10; ?>), color-stop(100%, <?php echo $highlight; ?>));
		background-image: -webkit-linear-gradient(top, <?php echo $lighten10; ?>, <?php echo $highlight; ?>);
		background-image: -o-linear-gradient(top, <?php echo $lighten10; ?>, <?php echo $highlight; ?>);
		background-image: linear-gradient(top, <?php echo $lighten10; ?>, <?php echo $highlight; ?>);
	}
	.secondary form input#submit:active,
	a.btn:active, input#submit:active, input[type='submit']:active, button:active {
		color: <?php echo $darken22; ?>;
		background-color: <?php echo $highlight; ?>;
		background-repeat: repeat-x;
		background-image: -khtml-gradient(linear, left top, left bottom, from(<?php echo $darken10; ?>), to(<?php echo $highlight; ?>));
		background-image: -moz-linear-gradient(top, <?php echo $darken10; ?>, <?php echo $highlight; ?>);
		background-image: -ms-linear-gradient(top, <?php echo $darken10; ?>, <?php echo $highlight; ?>);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $darken10; ?>), color-stop(100%, <?php echo $highlight; ?>));
		background-image: -webkit-linear-gradient(top, <?php echo $darken10; ?>, <?php echo $highlight; ?>);
		background-image: -o-linear-gradient(top, <?php echo $darken10; ?>, <?php echo $highlight; ?>);
		background-image: linear-gradient(top, <?php echo $darken10; ?>, <?php echo $highlight; ?>);
		text-shadow: 0 1px 0 <?php echo $lighten10; ?>;
	}

	.related-container h3:after {
		<?php cssRule("background-color", $highlight); ?>
	}

	#filter li.current a {
		<?php cssRule("color", $highlight); ?>
	}

	.works .meta {
		<?php cssRule("border-top-color", $highlight); ?>
	}

	.works .work-nav li a:hover {
		<?php cssRule("background-color", $highlight); ?>
	}

	.text .dropcap1,
	.textwidget .dropcap1,
	.text .dropcap3,
	.textwidget .dropcap3 {
		<?php cssRule("background-color", $highlight); ?>
	}

	.pricing-table .plan.featured {
		<?php cssRule("border-color", $highlight); ?>
	}

	.pricing-table .plan.featured .plan-head {
		<?php cssRule("background-color", $highlight); ?>
		<?php cssRule("border-bottom-color", $darken5); ?>
	}

<?php endif; ?>

<?php // Custom fonts ----------------------------------------------------------------------------- ?>

body #main-nav {
	<?php cssRule("background-color", thb_get_option("_submenu_background_color")); ?>
}

body #main-nav a {
	<?php displayFontRules("_font_menu"); ?>
}

body #main-nav ul.sub-menu li {
	<?php cssRule("border-top-color", lighten("#" . thb_get_option("_submenu_background_color"), 10)); ?>
}

body #main-nav .sub-menu li a {
	<?php displayFontRules("_font_submenu"); ?>
}

body #main-nav ul.sub-menu li a:hover,
body #main-nav ul.sub-menu li.menu-item-hover > a {
	<?php cssRule("color", darken("#" . thb_get_option("_font_submenu_color"), 20)); ?>
	<?php cssRule("background-color", darken(thb_get_option("_submenu_background_color"), 5)); ?>
}


body .content .page-header h1 {
	<?php displayFontRules("_font_pagetitle"); ?>
}

body .content .page-header h2 {
	<?php displayFontRules("_font_pagesubtitle"); ?>
}

body {
	<?php displayFontRules("_font_text"); ?>
}

body .widget header h3 {
	<?php displayFontRules("_font_widgetheadings"); ?>
}

body #page-top-sidebar .widget header h3 {
	<?php displayFontRules("_font_topareawidgetheadings"); ?>
}

body #footer-sidebar {
	<?php displayFontRules("_font_footertext"); ?>
		<?php 
		$footerwidgetarea_background_color = thb_get_option("_footerwidgetarea_background_color");
		if( !empty($footerwidgetarea_background_color) ) : ?>
			border-bottom: none;
			padding-top: 30px;
			padding-bottom: 30px;
			margin-top: 20px;
		<?php endif; ?>
}

body #footer,
body #footer a,
body #footer-sidebar a {
	<?php displayFontRules("_font_footertext"); ?>
}

body #footer-sidebar .widget header h3 {
	<?php displayFontRules("_font_footerareawidgetheadings"); ?>
}

body .slide-overlay h1.slide-heading {
	<?php displayFontRules("_font_slideheading"); ?>
}

<?php // Custom colors ---------------------------------------------------------------------------- ?>

body #top-bar {
	<?php cssRule("background-color", "#" . thb_get_option("_topbar_background_color")); ?>
}

body #main-nav {
	<?php cssRule("background-color", "#" . thb_get_option("_menu_background_color")); ?>
}

body #main-nav ul.sub-menu li a {
	<?php cssRule("background-color", "#" . thb_get_option("_submenu_background_color")); ?>
}

body #page-top-sidebar {
	<?php cssRule("background-color", "#" . thb_get_option("_topwidgetarea_background_color")); ?>
}

body #main-container {
	<?php cssRule("background-color", "#" . thb_get_option("_body_background_color")); ?>
}

body #footer-sidebar {
	<?php cssRule("background-color", "#" . thb_get_option("_footerwidgetarea_background_color")); ?>
}

<?php // Background overlay -----------------------------------------------------------------------

$background_pattern_overlay = thb_get_option("_background_pattern_overlay");
$background_pattern_repeat = "repeat";
$background_pattern_position = "top left";

if( $background_pattern_overlay == "custom" ) {
	$background_pattern_overlay = thb_get_option("_custom_pattern");
	$background_pattern_repeat = thb_get_option("_custom_pattern_repeat");
	$background_pattern_position = thb_get_option("_custom_pattern_position");
}

if( !empty($background_pattern_overlay) )
	echo "\n.background_overlay { \n
		background-image: url({$background_pattern_overlay}); \n
		background-repeat: {$background_pattern_repeat}; \n
		background-position: {$background_pattern_position};
	}\n";

// Custom stylesheet option -----------------------------------------------------------------------

$custom_css = thb_get_option("_custom_css", true);
if( !empty($custom_css) )
	echo $custom_css;