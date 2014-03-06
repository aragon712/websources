<?php
/**
 * Control for Theme Slider in admin panel
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
 * Add control to slider
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @global array List of all customization options
 *
 * @return array
 */
function websources_customize_register() {

	global $wp_customize;
	
	/**
	 * Add extended setting for featured content section
	 */
	$wp_customize->add_setting( 'num_posts_grid',       array( 'default'    => '6' ) );
	$wp_customize->add_setting( 'num_posts_slider',     array( 'default' 	=> '6' ) );
	$wp_customize->add_setting( 'speed_posts_slider',   array( 'default' 	=> '5000' ) );
	$wp_customize->add_setting( 'delay_posts_slider',   array( 'default' 	=> '5000' ) );
	$wp_customize->add_setting( 'layout_mobile',        array( 'default' 	=> 'grid' ) );
	
	/**
	 * Add extended control for featured content section
	 */
	$wp_customize->add_control( 'num_posts_grid', array(
		'label' 	=> __( 'Number of posts for grid', 'websources' ),
		'section' 	=> 'featured_content',
		'settings' 	=> 'num_posts_grid',
	) );
	
	$wp_customize->add_control( 'num_posts_slider', array(
		'label' 	=> __( 'Number of posts for slider', 'websources' ),	
		'section' 	=> 'featured_content',
		'settings'	=> 'num_posts_slider',
	) );
	
	$wp_customize->add_control( 'speed_posts_slider', array(
		'label'		=> __( 'Speed of transition for slider (ms)', 'websources' ),
		'section'	=> 'featured_content',
		'settings'	=> 'speed_posts_slider',
	) );
	
	$wp_customize->add_control( 'delay_posts_slider', array(
		'label'		=> __( 'Initial delay for slider (ms)', 'websources' ),
		'section'	=> 'featured_content',
		'settings'	=> 'delay_posts_slider',
	) );
	
	$wp_customize->add_control( 'layout_mobile', array(
		'label'		=> __( 'Layout for mobile device', 'websources' ),
		'section'	=> 'featured_content',
		'settings'	=> 'layout_mobile',
		'type'		=> 'select',
		'choices'	=> array(
			'grid' 		=> __( 'Grid', 'twentyfourteen' ),
			'slider'	=> __( 'Slider', 'twentyfourteen' )
		),
	) );
}
add_action( 'customize_register', 'websources_customize_register' );

/**
 * Add slider initialization to footer
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_initialise_slider() {
	$layout = get_theme_mod( 'featured_content_layout' );
	if ( $layout = 'slider' ) {
		$speed = get_theme_mod( 'speed_posts_slider', 4500 );
		$dalay = get_theme_mod( 'speed_posts_slider', 0 );
	?>
		<script type="text/javascript">
			( function( $ ) {
				var body = $( 'body' ), _window = $( window );
				_window.load( function() {
					if ( body.is( '.slider' ) ) {
						$( '.featured-content' ).flexslider( {
							selector: '.featured-content-inner > article',
							controlsContainer: '.featured-content',
							slideshow: true,
							slideshowSpeed: <?php echo $speed; ?>,
							initDelay: <?php echo $daley; ?>,
							namespace: 'slider-',
						} );
					}
				} );
			} ) ( jQuery );
		</script>
	<?php
	}
}
add_action( 'wp_footer', 'websources_initialise_slider' );

