<?php
/**
 * Template for Header
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
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</a>
	</div>
	<?php endif; ?>
	    
	<?php if ( wp_is_mobile() ) : ?><!-- check if is a mobile browser -->

        <header id="masthead" class="site-header" role="banner">
            <div class="header-main">
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
           		<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( ! empty ( $description ) ) :
				?>
				<h2 class="topbar-description"><?php echo esc_html( $description ); ?></h2>
				<?php endif; ?>
            </div>
            <a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
            <a id="menu-toggle"  class="second" title="<?php _e( 'Click To Show Sidebar', 'websources' ); ?>" href="#slideout"><span class="genericon genericon-menu"></span></a>
        </header><!-- #masthead -->

	<?php else:  ?><!-- if wp_is_mobile is false -->

        <header id="masthead" class="site-header" role="banner">
            <div id="big-top">
                <div class="header-main">
                
                <!-- Inizio Nuovo Header -->
                <?php if ( get_theme_mod( 'logo_image' ) ) : ?>
                	<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_theme_mod( 'logo_image' ); ?>"></a></span>
                <?php else : ?>

                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                </div>
                <?php endif ?>
                <!-- Fine Nuovo header -->
                <?php
                    $description = get_bloginfo( 'description', 'display' );
                    if ( ! empty ( $description ) ) :
                ?>
                <h2 class="topbar-description"><?php echo esc_html( $description ); ?></h2>
                <?php endif; ?>
            </div>

            <nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
            
            
                <div class="search-toggle">
                    <a href="#search-container" class="screen-reader-text"><?php _e( 'Search', 'twentyfourteen' ); ?></a>
                </div>
                <div id="search-container" class="search-box-wrapper hide">
                    <div class="search-box">
                        <?php get_search_form(); ?>
                    </div>
                </div>
                <h1 class="menu-toggle"><?php _e( 'Primary Menu', 'twentyfourteen' ); ?></h1>
                <a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'container_class' => 'topbar-menu', ) ); ?>

            </nav>

        </header><!-- #masthead -->

	<?php endif; ?>

	<div id="main" class="site-main">

