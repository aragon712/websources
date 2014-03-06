<?php
/**
 * Template Tags for AudioTheme
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
 */
/**
 * Find archive title
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 *
 * @param string $post
 * @param bool $singular
 *
 * @return string
 */
function websources_get_archive_title( $post = null, $singular = false ) {
	$post = get_post( $post );
	if ( $singular ) 	{
		$title = get_post_type_object( $post->post_type )->label->singular_name;
	} else 	{
		$title = get_post_type_object( $post->post_type )->label;
	}
	return $title;
}

/**
 * Print archive title
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_archive_link() {
	$post_type = get_post_type();
	$link = get_post_type_archive_link( $post_type );
	if ( 'audiotheme_track' == $post_type ) {
		$link = get_permalink( get_post()->post_parent );
	}
?>	<a href="<?php echo esc_url( $link ); ?>">
	<?php
		echo esc_html( websources_get_archive_title() ); 
}

/**
 * Print list of site partner
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function twentyfourteen_list_authors() {
	$member_ids = array_filter( wp_parse_id_list( get_post_meta( get_the_ID(), 'member_ids', true ) ) );
	$contributor_ids = $member_ids;
	if ( empty( $contributor_ids ) ) {
		$contributor_ids = get_users( array(
			'fields'  => 'ID',
			'orderby' => 'post_count',
			'order'   => 'DESC',
			'who'     => 'authors',
		) );
	}

	websources_contributor_page_content();
	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );
		if ( empty( $member_ids ) && ! $post_count ) {
			continue;
		}
		?>
		<div class="contributor">
			<div class="contributor-info">
				<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
				<div class="contributor-summary">
					<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
					<p class="contributor-bio">
						<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
					</p>
					<?php if ( $post_count ) : ?>
						<a class="contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
							<?php printf( _n( '%d Article', '%d Articles', $post_count, 'twentyfourteen' ), $post_count ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $twitter_username = get_the_author_meta( 'twitter', $contributor_id ) ) : ?>
						<span class="icon">
							<a class="contributor-twitter-link" href="<?php echo esc_url( 'http://twitter.com/' . $twitter_username ); ?>" target="_blank">
								<?php _e( 'Twitter', 'twentyfourteen' ); ?>
							</a>
						</span>
					<?php endif; ?>
					<?php if ( $facebook_url = get_the_author_meta( 'facebook', $contributor_id ) ) : ?>
						<span class="icon">
							<a class="contributor-facebook-link" href="<?php echo esc_url( $facebook_url ); ?>" target="_blank">
								<?php _e( 'Facebook', 'twentyfourteen' ); ?>
							</a>
						</span>
					<?php endif; ?>
					<?php if ( $website_url = get_the_author_meta( 'user_url', $contributor_id ) ) : ?>
						<span class="icon icon-link">
							<a class="contributor-website-link" href="<?php echo esc_url( $website_url ); ?>" target="_blank">
								<?php _e( 'Website', 'twentyfourteen' ); ?>
							</a>
						</span>
					<?php endif; ?>
					<?php if ( is_user_logged_in() && current_user_can( 'edit_user', $contributor_id ) ) : ?>
						<span class="icon icon-link">
							<a class="contributor-edit-link" href="<?php echo esc_url( get_edit_user_link( $contributor_id ) ); ?>" target="_blank">
								<?php _e( 'Edit', 'twentyfourteen' ); ?>
							</a>
						</span>
					<?php endif; ?>
				</div><!-- .contributor-summary -->
			</div><!-- .contributor-info -->
		</div><!-- .contributor -->
		<?php
	endforeach;
}

/**
 * Tamplate for contrib page
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_contributor_page_content() {
	if ( '' != get_post()->post_content ) :
	?>
		<div class="entry-content">
			<?php
			the_content();
			wp_link_pages( array( 
				'before'        => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>', 
				'after'         => '</div>',
				'link_before'   => '<span>',
				'link_after'    => '</span>',
			) );
			?>
		</div><!--- entry-content -->
	<?php
	endif;
}
