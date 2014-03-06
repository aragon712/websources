<?php
/**
 * Show About Author notice
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
function websources_about_author( $content ) {
        global $post;
        $email = get_the_author_meta( 'email' );
        $default = get_stylesheet_directory_uri() . '/images/authorbio/default.png';
        $size = 70;
        $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&amp;s=" . $size;
        $websources_author_bio = array();
        $websources_author_bio['name'] = get_the_author();
        $websources_author_bio['description'] = get_the_author_meta( 'description' );
        $websources_author_bio['gravatar'] = get_avatar( get_the_author_meta( 'email' ), '50' );       
        if ( !is_feed() && !is_home() && !is_404() && !is_archive() && !is_page() && !is_category() ) {
                $content .= '<div id="aboutauthor"><div class="infoauthor">'; 
                $content .= '<img class="gravatar" src="' . $grav_url . '" alt="" />'; 
                $content .= '<p class="nameauthor">' . __( 'About', 'websources' ) . ' ' . $websources_author_bio['name'] . '</p>';          
                $content .= '<p class="description">' . $websources_author_bio['description'] . '</p><br />';
	        $content .='</div></div>'; 	   
        }
	return $content;
}

add_filter( 'the_content', 'websources_about_author' );

?>
 
