<?php
/**
 * Main function file
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@websources.it so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.websources.it for more information.
 *
 * @package WordPress
 * @subpackage WebSources
 * @since WebSources 1.0
 */
/**
 * Disable WordPress Admin Bar for all User
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Add Sidebar For Mobile Device
 *
 * Add e new Sidebar in your own Widget area customization for menu or 
 * other widget displayed in mobile device. 
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_mobile_widget_area() {
	register_sidebar( array(
		'name'          => __( 'Mobile Sidebar', 'websources' ),
		'id'            => 'sidebar-mobile',
		'description' 	=> __( 'Slideout sidebar for mobile devices.', 'websources' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s mobile-widget">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h1 class="widget-title">',
		'after_title' 	=> '</h1>',
	) );
}
add_action( 'widgets_init', 'websources_mobile_widget_area' );


/**
 * Setup Theme
 *
 * This function load text domain and register Nav Menu
 * 
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_setup() {

	/**
	 * Loads text domain
	 */
	load_child_theme_textdomain ( 'websources', get_stylesheet_directory() . '/languages' );
	/**
	 * Register nav manus
	 */
	register_nav_menus( array(
		'mobile' => __( 'Mobile menu in left sidebar', 'websources' ),
	) );

}
add_action( 'after_setup_theme', 'websources_setup' );

/**
 * Sidebar add only is mobile device
 * 
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
if ( wp_is_mobile() ) {
        function websources_add_slideout() {
	wp_enqueue_script( 'sidr',      get_stylesheet_directory_uri()  . '/js/jquery.sidr.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'slideout',  get_stylesheet_directory_uri()  . '/js/slideout.js', array( 'sidr' ), null, true );
	wp_enqueue_style( 'slideout',   get_stylesheet_directory_uri()  . '/css/jquery.sidr.dark.css');
        }
	add_action( 'wp_enqueue_scripts', 'websources_add_slideout', 10 );
}

/**
 * Add topbar only if not is a mobile device
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
if ( !wp_is_mobile() ) {

        function websources_add_topbarjs() {
	        wp_enqueue_script( 'topbarjs',  get_stylesheet_directory_uri()  . '/js/topbar.js', array( 'jquery' ), null, true );
        }
	add_action( 'wp_enqueue_scripts', 'websources_add_topbarjs' );
}

/**
 * Determine the slider visualization
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param string $value Value Slide or Grid in Featured Content
 *
 * @return string 
 */
function websources_theme_mod( $value ) {
	if ( wp_is_mobile() ) {
		return get_theme_mod( 'layout_mobile', 'grid' );
	} else {
		return $value;
	}
}
add_filter( 'theme_mod_featured_content_layout', 'websources_theme_mod' );

/**
 * Get featured posts
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param array $posts List of post
 *
 * @return array
 */
function websources_get_featured_posts( $posts ) {

	$fc_options = (array) get_option( 'featured-content' );
	
	if ( $fc_options ) {
		$tag_name = $fc_options['tag-name'];
	} else {
		$tag_name = 'featured';
	}
	
	$layout = get_theme_mod( 'featured_content_layout' );
	$max_posts = get_theme_mod( 'num_posts_' . $layout, 2 );
	
	$args = array(
		'post_type'         => array( 'post', '[custom post type]' ),
		'tag'               => $tag_name,
		'posts_per_page'    => $max_posts,
		'order_by'          => 'post_date',
		'order'             => 'DESC',
		'post_status'       => 'publish',
	);
	
	$new_post_array = get_posts( $args );
	
	if ( count( $new_post_array ) > 0 ) {
		return $new_post_array;
	} else {
		return $posts;
	}
}
add_filter( 'twentyfourteen_get_featured_posts', 'websources_get_featured_posts', 999, 1 );

/**
 * Dequeue and Enqueue JavaScript and CSS
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_adding_scripts() {
	wp_dequeue_script( 'twentyfourteen-script' );
    	wp_dequeue_script( 'twentyfourteen-slider' );
    	wp_enqueue_script( 'websources-script', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery' ), '' , true );
    	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
      		wp_enqueue_script( 'websources-slider', get_stylesheet_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery', 'websources-script' ), '' , true );
            	wp_localize_script( 'websources-slider', 'featuredSliderDefaults', array(
               		'prevText' => __( 'Previous', 'twentyfourteen' ),
                	'nextText' => __( 'Next', 'twentyfourteen' )
            	) );
	}
	wp_enqueue_script( 'scrollup', get_stylesheet_directory_uri() . '/js/smooth_scroll.js', array( 'jquery' ), '', true );
}

add_action( 'wp_enqueue_scripts', 'websources_adding_scripts' , 999 );

/**
 * Add link Back To Top
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_scrollup() {
?>
	<a href="#top" id="scrollup" title="Back to top"></a>
<?php
}
add_action( 'wp_footer', 'websources_scrollup' );

/**
 * Remove ?ver= from JS and CSS
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param string $ver String ?ver= to remove
 *
 * @return string 
 */
function websources_remove_css_js_ver( $ver )
{
	if ( strpos( $ver, '?ver=' ) )
		$ver = remove_query_arg( 'ver', $ver );
	return $ver;
}
add_filter( 'style_loader_src', 'websources_remove_css_js_ver', 9999 );
add_filter( 'script_loader_src', 'websources_remove_css_js_ver', 9999 );

remove_action( 'wp_head', 'wp_generator' );
/**
 * Remove WordPress Version Number
 *
 * @since WebSources 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 */
function websources_remove_wp_version_rss()
{
	return '';
}
add_filter( 'the_generator', 'websources_wp_version_rss' );

/**
 * Customize theme panel
 * 
 * @since WebSources 1.0
 */
require get_stylesheet_directory() . '/functions/author-bio.php';
require get_stylesheet_directory() . '/inc/customizer-slider.php';
require get_stylesheet_directory() . '/inc/customizer-title.php';


/**
 * Add AudioTheme
 *
 * @since WebSources 1.0
 */
require get_stylesheet_directory() . '/functions/audiotheme/audiotheme.php';

/**
 * Add WooCommerce support
 *
 * @since WebSources 1.0
 */
require get_stylesheet_directory() . '/woocommerce/theme-woocommerce.php';

