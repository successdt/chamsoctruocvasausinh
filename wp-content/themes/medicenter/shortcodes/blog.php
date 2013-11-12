<?php
//blog
function theme_blog($atts, $content)
{
	global $themename;
	extract(shortcode_atts(array(
		"mc_pagination" => 1,
		"items_per_page" => 4,
		"featured_image_size" => "default",
		"layout_type" => 1,
		"ids" => "",
		"category" => "",
		"order_by" => "title menu_order",
		"order" => "DESC",
		"show_post_title" => 1,
		"read_more" => 0,
		"show_post_categories" => 1,
		"show_post_author" => 1,
		"lightbox_icon_color" => "blue_light",
		"top_margin" => 'none'
	), $atts));
	
	$featured_image_size = str_replace("mc_", "", $featured_image_size);
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}	
	$category = explode(",", $category);
	if($category[0]=="-" || $category[0]=="")
	{
		unset($category[0]);
		$category = array_values($category);
	}
	global $paged;
	$paged = (get_query_var((is_front_page() ? 'page' : 'paged'))) ? get_query_var((is_front_page() ? 'page' : 'paged')) : 1;
	query_posts(array( 
		'post__in' => $ids,
		'post_type' => 'post',
		'post_status' => 'publish',
		's' => get_query_var('s'),
		'paged' => $paged,
		'posts_per_page' => $items_per_page,
		'cat' => (get_query_var('cat')!="" ? get_query_var('cat') : implode(",", $category)),
		'tag' => get_query_var('tag'),
		'monthnum' => get_query_var('monthnum'),
		'day' => get_query_var('day'),
		'year' => get_query_var('year'),
		'w' => get_query_var('week'),
		'orderby' => '"' . implode(" ", explode(",", $order_by)) . '"',
		'order' => $order
	));
	global $wp_query;
	$post_count = $wp_query->post_count;
	
	$output = '';
	if((int)$layout_type==2)
		$output .= '<div class="columns clearfix">';
	$i = 0;
	if(have_posts()) : while (have_posts()) : the_post();
		if($i==0 || ((int)$layout_type==2 && $i==ceil($post_count/2)))
		{
			if($i==ceil($post_count/2))
				$output .= '</ul>';
			$output .= '<ul class="blog' . ((int)$layout_type==3 ? ' simple' : '') . ((int)$layout_type==2 ? ($i==ceil($post_count/2) ? ' column_right' : ' column_left') : ' clearfix') . ($top_margin!="none" ? ' ' . $top_margin : '') . '">';
		}
		$post_classes = get_post_class("post");
		$output .= '<li class="' . ((int)$layout_type==3 ? 'item_content ' : '');
		foreach($post_classes as $key=>$post_class)
			$output .= $post_class . ($key+1<count($post_classes) ? ' ' : '');
		$output .= '">';
		if((int)$layout_type!=3)
		{
			$output .= '<ul class="comment_box clearfix">
							<li class="date' . ((int)$layout_type!=2 ? ' clearfix' : '' ) . '">
								<div class="value">' . strtoupper(date_i18n("d M y", strtotime(get_the_time("d M Y")))) . '</div>
								<div class="arrow_date"></div>
							</li>
							<li class="comments_number">';
							$comments_count = get_comments_number();
		$output .= '			<a href="' . get_comments_link() . '" title="' . $comments_count . ' ' . ($comments_count==1 ? __('comment', 'medicenter') : __('comments', 'medicenter')) . '">' . $comments_count . ((int)$layout_type!=2 ? ' ' . ($comments_count==1 ? __('comment', 'medicenter') : __('comments', 'medicenter')) : '') . '</a>
							</li>
						</ul>
						<div class="post_content">';
						$show_images_in = get_post_meta(get_the_ID(), $themename . "_show_images_in", true);
						$attachment_ids = get_post_meta(get_the_ID(), $themename . "_attachment_ids", true);
						$images = get_post_meta(get_the_ID(), $themename . "_images", true);
						$images_count = count((array)$images);
						if($images_count>0 && ($show_images_in=="blog" || $show_images_in=="both"))
						{
							$images_titles = get_post_meta(get_the_ID(), $themename . "_images_titles", true);
							$videos = get_post_meta(get_the_ID(), $themename . "_videos", true);
							$iframes = get_post_meta(get_the_ID(), $themename . "_iframes", true);
							$external_urls = get_post_meta(get_the_ID(), $themename . "_external_urls", true);
							$features_images_loop = get_post_meta(get_the_ID(), $themename . "_features_images_loop", true);
							$output .= '<div class="gallery_box">
								<ul class="image_carousel">';
								if(has_post_thumbnail())
								{
									$thumb_id = get_post_thumbnail_id(get_the_ID());
									$attachment_image = wp_get_attachment_image_src($thumb_id, "large");
									$large_image_url = $attachment_image[0];
									$thumbnail_image = get_posts(array('p' => $thumb_id, 'post_type' => 'attachment'));
									$output .= '<li><span class="mc_preloader"></span>
									' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : ($layout_type==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt" => get_the_title(), "title" => "")) . '
										<ul class="controls">
											<li>
												<a href="' . $large_image_url . '" title="' . esc_attr($thumbnail_image[0]->post_title) . '" class="fancybox open_lightbox"' . ($features_images_loop=="yes" ? ' rel="featured_' . get_the_ID() . '"' : '') . ' style="background-image: url(\'' . get_template_directory_uri() . '/images/icons_media/' . $lightbox_icon_color . '/image.png\')"></a>
											</li>
										</ul>
									</li>';
								}
							for($j=0; $j<$images_count; $j++)
							{
								$output .= '<li>' . ($j==0 && !has_post_thumbnail() ? '<span class="mc_preloader"></span>' : '') .
									wp_get_attachment_image((int)$attachment_ids[$j], ($featured_image_size!="default" ? $featured_image_size : ($layout_type==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt "=> "")) . '
										<ul class="controls">
											<li>
												<a' . (isset($external_urls[$j]) && $external_urls[$j]!="" ? ' target="_blank"' : '') . ' href="' . (isset($external_urls[$j]) && $external_urls[$j]!="" ? $external_urls[$j] : (isset($iframes[$j]) && $iframes[$j]!="" ? $iframes[$j] : (isset($videos[$j]) && $videos[$j]!="" ? $videos[$j] : $images[$j]))) . '" title="' . (isset($images_titles[$j]) ? esc_attr($images_titles[$j]) : '') . '" class="fancybox' . (isset($external_urls[$j]) && $external_urls[$j]!="" ? '-externalurl' : (isset($iframes[$j]) && $iframes[$j]!="" ? '-iframe' : (isset($videos[$j]) && $videos[$j]!="" ? '-video' : '' ))) . ' open_' . ((isset($external_urls[$j]) && $external_urls[$j]!="") || (isset($iframes[$j]) && $iframes[$j]!="") ? 'iframe_' : (isset($videos[$j]) && $videos[$j]!="" ? 'video_' : '' )) . 'lightbox"' . ($features_images_loop=="yes" ? ' rel="featured_' . get_the_ID() . '"' : '') . ' style="background-image: url(\'' . get_template_directory_uri() . '/images/icons_media/' . $lightbox_icon_color . '/' . (isset($videos[$j]) && $videos[$j]!="" ? 'video' : ((isset($iframes[$j]) && $iframes[$j]!="") || (isset($external_urls[$j]) && $external_urls[$j]!="") ? 'url' : 'image')) . '.png\')"></a>
											</li>
										</ul>
									</li>';
							}
							$output .= '</ul>
							</div>';
						}
						else if(has_post_thumbnail())
							$output .= '<a class="post_image" href="' . get_permalink() . '" title="' . get_the_title() . '"><span class="mc_preloader"></span>' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : ($layout_type==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt" => get_the_title(), "title" => "")) . '</a>';	
		}
		else
		{
			if(has_post_thumbnail())
				$output .= '<a class="thumb_image" href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : $themename . "-small-thumb"), array("alt" => get_the_title(), "title" => "")) . '</a>';	
		}
						if((int)$layout_type==3)
							$output .= ((int)$layout_type==3 ? '<div class="text">' : '');
						if((int)$show_post_title)
							$output .= ((int)$layout_type==3 ? '<h3> ' : '<h2>' ) . '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>' . ((int)$layout_type==3 ? '</h3> ' : '</h2>' );
						$output .= apply_filters('the_excerpt', get_the_excerpt());
						if((int)$layout_type==3)
							$output .=  '</div>';
							if((int)$read_more)
								$output .= ((int)$layout_type==3 ? '<div class="clearfix more_container">' : '') . '<a title="' . __('Read more', 'medicenter') . '" href="' . get_permalink() . '" class="more">' . __('Read more &rarr;', 'medicenter') . '</a>' . ((int)$layout_type==3 ? '</div>' : '');
							if((int)$show_post_categories || (int)$show_post_author)
							{
		$output .= '		<div class="post_footer clearfix">';
								if((int)$show_post_categories)
								{
								$output .= '<ul class="post_footer_details">';
									$categories = get_the_category();
									$output .= '<li>' . __('Posted in ', 'medicenter') . '</li>';
									foreach($categories as $key=>$category)
									{
										$output .= '<li>
											<a href="' . get_category_link($category->term_id ) . '" ';
										if(empty($category->description))
											$output .= 'title="' . sprintf(__('View all posts filed under %s', 'medicenter'), $category->name) . '"';
										else
											$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
										$output .= '>' . $category->name . '</a>' . ($category != end($categories) ? ', ' : '') . '
										</li>';
									}
		$output .= '			</ul>';
								}
								if((int)$show_post_author)
								{
								$output .= '<ul class="post_footer_details">
									<li>' . __('Posted by', 'medicenter') . '</li>
									<li>
										' . (get_the_author_meta("user_url")!="" ? '<a class="author" href="' . get_the_author_meta("user_url") . '" title="' . get_the_author() . '">' . get_the_author() . '</a>' : get_the_author()) . '
									</li>
								</ul>';
								}
							$output .= '</div>';
							}
		$output .= ((int)$layout_type!=3 ? '</div>' : '') .	'</li>';
		$i++;
	endwhile; endif;
	$output .= '</ul>';
	if((int)$layout_type==2)
		$output .= '</div>';
	
	if($mc_pagination)
	{
		locate_template("pagination.php", true);
		$output .= kriesi_pagination(false, '', 2, false, false, '', 'page_margin_top');
	}
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("blog", "theme_blog");

//visual composer
function theme_blog_vc_init()
{
	//get posts list
	$posts_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'post'
	));
	$posts_array = array();
	$posts_array[__("All", 'medicenter')] = "-";
	foreach($posts_list as $post)
		$posts_array[$post->post_title . " (id:" . $post->ID . ")"] = $post->ID;

	//get categories
	$post_categories = get_terms("category");
	$post_categories_array = array();
	$post_categories_array[__("All", 'medicenter')] = "-";
	foreach($post_categories as $post_category)
		$post_categories_array[$post_category->name] =  $post_category->slug;
	
	//image sizes
	$image_sizes_array = array();
	$image_sizes_array[__("Default", 'medicenter')] = "default";
	global $_wp_additional_image_sizes;
	foreach(get_intermediate_image_sizes() as $s) 
	{
		if(isset($_wp_additional_image_sizes[$s])) 
		{
			$width = intval($_wp_additional_image_sizes[$s]['width']);
			$height = intval($_wp_additional_image_sizes[$s]['height']);
		} 
		else
		{
			$width = get_option($s.'_size_w');
			$height = get_option($s.'_size_h');
		}
		$image_sizes_array[$s . " (" . $width . "x" . $height . ")"] = "mc_" . $s;
	}
	wpb_map( array(
		"name" => __("Blog", 'medicenter'),
		"base" => "blog",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-blog",
		"category" => __('MediCenter', 'medicenter'),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Pagination", 'medicenter'),
				"param_name" => "mc_pagination",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Items per page/Post count", 'medicenter'),
				"param_name" => "items_per_page",
				"value" => 4,
				"description" => __("Items per page if pagination is set to 'yes' or post count otherwise. Set -1 to display all.", 'medicenter')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Featured image size", 'medicenter'),
				"param_name" => "featured_image_size",
				"value" => $image_sizes_array
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Layout type", 'medicenter'),
				"param_name" => "layout_type",
				"value" => array(__("Type 1", 'medicenter') => 1, __("Type 2", 'medicenter') => 2, __("Type 3 (simple)", 'medicenter') => 3)
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Display selected", 'medicenter'),
				"param_name" => "ids",
				"value" => $posts_array
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Display from Category", 'medicenter'),
				"param_name" => "category",
				"value" => $post_categories_array
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Order by", 'medicenter'),
				"param_name" => "order_by",
				"value" => array(__("Title, menu order", 'medicenter') => "title,menu_order", __("Menu order", 'medicenter') => "menu_order")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Order", 'medicenter'),
				"param_name" => "order",
				"value" => array( __("descending", 'medicenter') => "DESC", __("ascending", 'medicenter') => "ASC")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post title", 'medicenter'),
				"param_name" => "show_post_title",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Read more button", 'medicenter'),
				"param_name" => "read_more",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post categories", 'medicenter'),
				"param_name" => "show_post_categories",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post author", 'medicenter'),
				"param_name" => "show_post_author",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Lightbox icon color", 'medicenter'),
				"param_name" => "lightbox_icon_color",
				"value" => array(
					__("light blue", 'medicenter') => 'blue_light', 
					__("dark blue", 'medicenter') => 'blue_dark',
					__("blue", 'medicenter') => 'blue',
					__("black", 'medicenter') => 'black',
					__("gray", 'medicenter') => 'gray',
					__("dark gray", 'medicenter') => 'gray_dark',
					__("light gray", 'medicenter') => 'gray_light',
					__("green", 'medicenter') => 'green',
					__("dark green", 'medicenter') => 'green_dark',
					__("light green", 'medicenter') => 'green_light',
					__("orange", 'medicenter') => 'orange',
					__("dark orange", 'medicenter') => 'orange_dark',
					__("light orange", 'medicenter') => 'orange_light',
					__("red", 'medicenter') => 'red',
					__("dark red", 'medicenter') => 'red_dark',
					__("light red", 'medicenter') => 'red_light',
					__("turquoise", 'medicenter') => 'turquoise',
					__("dark turquoise", 'medicenter') => 'turquoise_dark',
					__("light turquoise", 'medicenter') => 'turquoise_light',
					__("violet", 'medicenter') => 'violet',
					__("dark violet", 'medicenter') => 'violet_dark',
					__("light violet", 'medicenter') => 'violet_light',
					__("white", 'medicenter') => 'white',
					__("yellow", 'medicenter') => 'yellow'
				)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'medicenter'),
				"param_name" => "top_margin",
				"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page_margin_top", __("Section (large)", 'medicenter') => "page_margin_top_section")
			)
		)
	));
}
add_action("init", "theme_blog_vc_init");
?>
