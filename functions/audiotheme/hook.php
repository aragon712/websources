<?php
/**
 * Hook for AudioTheme
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
 * Extend the default AudioTheme post classes.
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param array $classes List of HTML class names.
 * @param string $class One or more classes added to the class list.
 * @param int $post_id The post ID.
 *
 * @return array
 */
function websources_post_audiotheme_classes( $classes, $class, $post_id ) {
	$post = get_post( $post_id );
	if ( 'audiotheme_track' == $post->post_type && ( has_post_thumbnail( $post_id ) || has_post_thumbnail( $post->post_parent ) ) ) {
		$classes[] = 'has-post-thumbnail';
	}
	if ( get_post_meta( get_the_ID(), 'member_ids', true ) ) {
		$classes[] = 'has-members';
	}
	return array_unique( $classes );
}
add_filter( 'post_class', 'websources_post_audiotheme_classes', 10, 3 );

/**
 * Add AudioTheme Post Types to featured posts query.
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param array $posts List of featured posts.
 *
 * @return array
 */
function websources_get_featured_audio_posts( $posts ) {
	$tag_id = Featured_Content::get_setting( 'tag-id' );
	// Return early if a tag id hasn't been set.
	if ( empty( $tag_id ) ) {
		return $posts;
	}
	// Query for featured posts.
	$featured = get_posts( array(
		'post_type' => array( 
			'audiotheme_record', 'audiotheme_video' 
		),
		'tax_query' => array(
			array(
				'field'    => 'term_id',
				'taxonomy' => 'post_tag',
				'terms'    => $tag_id,
				),
			),
		) );
	return array_merge( $posts, $featured );
}
add_filter( 'websources_get_featured_posts', 'twentyfourteen_child_get_featured_audio_posts', 20 );
