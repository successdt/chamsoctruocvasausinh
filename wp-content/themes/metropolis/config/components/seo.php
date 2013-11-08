<?php

if( is_404() )
	return;

/**
 * Author
 */
$_site_author = thb_get_option("_site_author");

/**
 * Site's description
 */
$_site_description = thb_get_option("_site_description");
if( is_single() ) {
	$_post_description = thb_get_post_meta(get_the_ID(), "_seo_description");
	if( !empty($_post_description) )
		$_site_description = $_post_description;
}

/**
 * Site's keywords
 */
$_keywords = thb_get_option("_keywords");
if( is_single() ) {
	$_post_keywords = thb_get_post_meta(get_the_ID(), "_seo_keywords");
	if( !empty($_post_keywords) )
		$_keywords .= ", " . $_post_keywords;
}

/**
 * Google verification
 */
$_google_verification = thb_get_option("_google_verification");

?>

<?php if( !empty($_site_author) ) : ?><meta name="author" content="<?php echo $_site_author; ?>"><?php endif ?>

<?php if( !empty($_site_description) ) : ?><meta name="description" content="<?php echo $_site_description; ?>"><?php endif ?>

<?php if( !empty($_keywords) ) : ?><meta name="keywords" content="<?php echo $_keywords; ?>"><?php endif ?>

<?php if( !empty($_google_verification) ) : ?><meta name="google-site-verification" content="<?php echo $_google_verification; ?>"><?php endif ?>