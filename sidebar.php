<?php
/**
 * Mobile Sidebar
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
?>
<?php

	if ( wp_is_mobile() ) :

	// display mobile sidebar - mostra la sidebar sui dispositivi mobili ?>
        <div id="slideout" class="sidr">
           <div id="slideout-top">
               <?php
                   $description = get_bloginfo( 'description', 'display' );
                   if ( ! empty ( $description ) ) :
                       ?>
                       <h2 class="site-description"><?php echo esc_html( $description ); ?></h2>
                <?php endif; ?>
               <div class="search-toggle">
                   <a href="#search-container" class="screen-reader-text"><?php _e( 'Search', 'twentyfourteen' ); ?></a>
               </div>
               <div id="search-container" class="search-box-wrapper hide">
                   <div class="search-box">
                       <?php get_search_form(); ?>
                   </div>
               </div>
            </div>

            <?php if ( has_nav_menu( 'mobile' ) ) : ?>
                <nav role="navigation" class="navigation site-navigation">
                    <?php wp_nav_menu( array( 'theme_location' => 'mobile' ) ); ?>
                </nav>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'sidebar-mobile' ) ) : ?>
                <div id="mobile-sidebar" class="widget-area" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-mobile' ); ?>
                </div><!-- #mobile-sidebar -->
            <?php endif;?></div>

        </div> <!-- #seconday-mobile -->

<?php
	else:
	
	// if not is mobile, display normal sidebar - se non è un dispositivo mobile mostra la sidebar normale ?>
	<div id="secondary">
		<?php if ( has_nav_menu( 'secondary' ) ) : ?>
		<nav role="navigation" class="navigation site-navigation secondary-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
		</nav>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #primary-sidebar -->
		<?php endif; ?>
	</div><!-- #secondary -->
		
<?php 
	endif;    ?>
