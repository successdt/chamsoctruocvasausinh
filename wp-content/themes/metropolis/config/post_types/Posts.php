<?php

/*
 * Post metaboxes (if any)
 */
function get_post_metaboxes() {
	$post_metaboxes = array(
	    __("Extra", THEMENAME) => array(
			"position" => "normal",
			"priority" => "normal",
			"fields" => array(
				array ( 
					"name" => "Background/slideshow",
					"desc" => "",
					"key" => "_background",
					"type" => "select",
					"options" => get_background_image_options(),
					"std" => 0
				)
			)
		),
		__("Slideshow", THEMENAME) => get_slideshow_metabox(),
		__("SEO", THEMENAME) => array(
			"id" => "seo",
			"position" => "side",
			"priority" => "normal",
			"fields" => array(
				array ( 
					"name" => "Keywords",
					"desc" => "Comma separated.",
					"key" => "_seo_keywords",
					"type" => "text",
					"std" => ""
				),
				array ( 
					"name" => "Description",
					"desc" => "",
					"key" => "_seo_description",
					"type" => "textarea",
					"std" => ""
				)
			)
		)
	);

	return $post_metaboxes;
}

add_action('add_meta_boxes', "register_posts_metabox");
add_action('save_post', "save_posts_metabox");

/**
 * Register the posts metabox
 */
function register_posts_metabox() {
	$post_metaboxes = get_post_metaboxes();

	if( empty($post_metaboxes) )
		return;

	$i=1;
	foreach($post_metaboxes as $name => $data) {
		$fields = $data['fields'];
		$position = $data['position'];
		$mb_key = thb_make_slug($name);
		add_meta_box("metabox_post_{$mb_key}", $name, "render_posts_metabox", "post", $position, 'low', array("metabox" => $fields));
		$i++;
	}
}

/**
 * Render the posts metabox
 */
function render_posts_metabox() {
	$args = func_get_args();
	$fields = $args[1]["args"]["metabox"];
	foreach($fields as $field) {
		adminpage::field($field, "post");
	}
}

/**
 * Save the posts metabox
 */
function save_posts_metabox() {
	$postdata = thb_get_data();

	if(!empty($postdata)) {
		global $post_id;
		global $post_type;
		
		$post_metaboxes = get_post_metaboxes();

		if( empty($post_metaboxes) )
			return;
		
		if($post_type == "post") {
			foreach($post_metaboxes as $name => $fields) {
				foreach($fields['fields'] as $field) {
					$key = THEMEPREFIX . $field['key'];

					if( $key == THEMEPREFIX )
						continue;

					$value = $postdata[$key];
					update_post_meta($post_id, $key, $value);
				}
			}
		}
	}
}