<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

add_theme_support( 'custom-logo' );

function themename_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'themename_custom_logo_setup' );

function customwidget() {
		register_sidebar( array(
		'name' => __( 'Site Logo', 'twentyten' ),
		'id' => 'site',
		'description' => __( 'The Site Logo widget area', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
		register_sidebar( array(
		'name' => __( 'Top Social Icon', 'twentyten' ),
		'id' => 'social',
		'description' => __( 'The social widget area', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
		register_sidebar( array(
		'name' => __( 'Banner Content', 'twentyten' ),
		'id' => 'baner',
		'description' => __( 'The banner content widget area', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'customwidget' );

function blog( $atts ){
  global $post;
$temp_post=$post;
$args = array( 'post_type' => 'post', 'posts_per_page' => 4);
$output .='<ul>';  
$outputposts = get_posts( $args );
foreach($outputposts as $post) : setup_postdata($post);
 $output .= '<li><a href="'.get_the_permalink().'">';
   $output .='<div class="zoom">'. get_the_post_thumbnail( $post->ID, 'full' ).'</div>';
   $output .= '<h3>'.get_the_title().'</h3>';
  $output .= '</a></li>';
endforeach;
$output .= '</ul>';
$post=$temp_post;
return $output;
}
add_shortcode( 'blog', 'blog' );
add_filter('use_block_editor_for_post', '__return_false', 10);