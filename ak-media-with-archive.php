<?php
/*
Plugin Name: Media with archive post plugin for AK Creative
Description: Used to dislay media with archive (e.g we love). Shortcode for posts: [akMedia post_type="posttype_name"]. Shortcode for archive : [akMedia-archive headline="The Success Archive" post_type="custom_post"]. 
*/

// Enqueue styles and scripts
add_action( 'wp_enqueue_scripts', 'add_mediaArchive_script' );
function add_mediaArchive_script() { 
	wp_enqueue_script( 'ak-mediaArchive-script', plugins_url('ak-media-with-archive/js/media-script.js'), array ( 'jquery' ), 1.1, true); 
}


// Create the archive shortcodes
add_shortcode("akMedia-archive", "akMediaArchive_sc");

// get all entries & order by date in dsc order
function akMediaArchive_sc($atts) {
	extract(shortcode_atts(array( "headline" => ''), $atts));
	extract(shortcode_atts(array( "post_type" => ''), $atts));

    global $post;

    $args = array(
    	'post_type' => $post_type, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    $output = '';

    $output .= 	'
    	<h4 class="ak-archive__headline ak-media-archive__headline">'.$headline.'</h4> 
    	<nav class="ak-archive ak-media-archive">
	    	<div class="ak-archive__list ak-media-archive__list">';

	    	$index = 1;
	    	foreach($custom_posts as $post) : setup_postdata($post);
		    	$slug = basename(get_permalink());
		    	$link = get_the_permalink();
		    	$thumbnail = get_the_post_thumbnail();

		    	$output .= 	
		    		'<a class="ak-media-archive__item ak-archive__item" slide="slide_'.$index.'" href="'.$link.'" 
		    		data-link="'.$slug.'">
		    			'.$thumbnail.'
		    		</a>'; 
				 $index++;
			endforeach; wp_reset_postdata();
			
			$output .= '</div>';
		$output .= '</nav>'; 
	return $output;
}


// Create the post shortcode
add_shortcode("akMedia", "akMedia_sc");

function ak_media_the_content( $more_link_text = null, $strip_teaser = false) {
    $content = get_the_content( $more_link_text, $strip_teaser );
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
}

function akMedia_sc($atts) {
	extract(shortcode_atts(array( "post_type" => ''), $atts));
    global $post;

    $args = array(
    	'post_type' => $post_type, 
    	'posts_per_page' => 10, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    $output = '';

	$index = 0;
    $output .= 	'
    	<div class="akMedia-wrapper">
	    	<div class="akMedia">'; 
		    
		    foreach($custom_posts as $post) : setup_postdata($post);
		    	$slug = basename(get_permalink());
		    	$title = get_the_title();
		    	$content = ak_media_the_content();
		    	$output .= 	'
		    	<div class="akMedia-post" id="'.$slug.'"
		    		data-index="'.$index.'" 
		    		data-behaviour="akMedia-post">
			        <h3 class="akMedia-post__headline">
			        	'.$title.'</h3>
			        
			        <div class="akMedia-post__content">'
			        	.$content.
			        '</div>
			    </div>';

			$index++;
		    endforeach; wp_reset_postdata();
	    	$output .= 	'</div>
		    <div class="ak-post-nav">
		    	<button class="ak-post-nav__button akMedia__button--prev">
		    	 	<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/ak-creative/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-left"></use></svg>
		    	</button>

		    	<div class="akMedia__social"> 
		    		<button class="ak-post-nav__button akMedia__button--linkedin">
		    			<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/ak-creative/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:linkedin"></use></svg>
		    		</button>

		    		<button class="ak-post-nav__button akMedia__button--twitter">
		    			<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/ak-creative/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:twitter"></use></svg>
		    		</button>

		    		<button class="ak-post-nav__button akMedia__button--facebook">
		    			<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/ak-creative/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:facebook"></use></svg>
		    		</button>
		    	</div>

		    	<button class="ak-post-nav__button akMedia__button--next">
		    	 	<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/ak-creative/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-right"></use></svg>
		    	</button>
		    </div>';
	    
		$output .= 	'</div>';
	return $output;
	}
?>
