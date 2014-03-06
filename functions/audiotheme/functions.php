<?php
/**
 * Functions for AudioTheme
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
 * Add theme support and image size for AudioTheme Framework
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_framework_setup() {
	add_theme_support( 'audiotheme-widgets', array( 'record', 'track', 'upcoming-gigs', 'video', ) );
	add_image_size( 'record-thumbnail', 672, 672, true );
	add_image_size( 'video-thumbnail', 672, 378, true );
}
add_action( 'after_setup_theme', 'websources_framework_setup' );

/**
 * HTML5 Template before AudioTheme content
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_before_main_content() {
	echo '<div id="main-content" class="main-content">';
	echo '<div id="primary" class="content-area">';
	echo '<div id="content" class="site-content" role="main">';
}
add_action( 'audiotheme_before_main_content', 'websources_before_main_content' );

/**
 * HTML5 Template after AudioTheme content
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_after_main_content() {
	echo '</div><!-- #content -->';
	echo '</div><!-- #primary -->';
	echo '</div><!-- #main-content -->';
	get_sidebar( 'content' );
	get_sidebar();
}
add_action( 'audiotheme_after_main_content', 'websources_after_main_content' );

/**
 * Adjust AudioTheme widget image sizes.
 *
 * HTML5 Template after AudioTheme content
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param array $size Image size (width and height).
 
 * @return array
 */
function websources_widget_image_size( $size ) {
	return array( 612, 612 ); // sidebar width x 2
}
add_filter( 'audiotheme_widget_record_image_size', 'websources_widget_image_size' );
add_filter( 'audiotheme_widget_track_image_size', 'websources_widget_image_size' );
add_filter( 'audiotheme_widget_video_image_size', 'websources_widget_image_size' );

/**
 * Activate default archive setting fields.
 *
 * HTML5 Template after AudioTheme content
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param array $fields List of default fields to activate.
 * @param string $post_type Post type archive.
 *
 * @return array
 */
function websources_archive_settings_fields( $fields, $post_type ) {
	if ( ! in_array( $post_type, array( 'audiotheme_record', 'audiotheme_video' ) ) ) {
		return $fields;
	}
	$fields['columns'] = array( 'choices' => range( 1, 2 ), 'default' => 2, );
	$fields['posts_per_archive_page'] = true;
	return $fields;
}
add_filter( 'audiotheme_archive_settings_fields', 'websources_archive_settings_fields', 10, 2 );

