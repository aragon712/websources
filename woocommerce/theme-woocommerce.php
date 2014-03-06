<?php
/**
 * WooCommerce compatibility
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
if ( in_array ( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'wc_twentyfourteen_wrapper', 10 );
	add_action( 'woocommerce_after_main_content', 'wc_twentyfourteen_wrapper_close', 10 );
	
	/**
	 * Open wrapper for display WooCoomerce shop page
	 *
	 * @since Version 1.0
	 * @author Adriano Giovannini <info@websources.it>
	 * @links http://wwww.websources.it
	 * @copyright Copyright (c) 2014, Adriano Giovannini
	 * @license See http://opensource.org/licenses/gpl-license.php
	 */
	function wc_twentyfourteen_wrapper() {
		echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
	}
	
	/**
	 * Close wrapper for display WooCommerce shop page
	 *
	 * @since Version 1.0
	 * @author Adriano Giovannini <info@websources.it>
	 * @links http://wwww.websources.it
	 * @copyright Copyright (c) 2014, Adriano Giovannini
	 * @license See http://opensource.org/licenses/gpl-license.php
	 */
	function wc_twentyfourteen_wrapper_close() {
		echo '</div></div></div>';
		get_sidebar( 'content' );
	}
	 add_action( 'wp_footer', 'wc_twentyfourteen_css' );
	 
	/**
	 * Add css style for page shop, product category, product taxonomy, product tag and product
	 *
	 * @since Version 1.0
	 * @author Adriano Giovannini <info@websources.it>
	 * @links http://wwww.websources.it
	 * @copyright Copyright (c) 2014, Adriano Giovannini
	 * @license See http://opensource.org/licenses/gpl-license.php
	 */
	function wc_twentyfourteen_css() {
		if ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() || is_product() ) {
	?>
		<style type="text/css">
			.twentyfourteen .tfwc {
				padding: 12px 10px 0;
				max-width: 474px;
				margin: 0 auto;
			}
			.twentyfourteen .tfwc .entry-summary {
				padding: 0 !important;
				margin: 0 0 1.618em !important;
			}
			.full-width .twentyfourteen .tfwc {
				margin-right: auto;
			}
	 		@media screen and (min-width: 673px) {
				.twentyfourteen .tfwc {
					padding-right: 30px;
					padding-left: 30px;
				}
			}
			@media screen and (min-width: 1040px) {
				.twentyfourteen .tfwc {
					padding-right: 15px;
					padding-left: 15px;
				}
			}
			@media screen and (min-width: 1110px) {
				.twentyfourteen .tfwc {
					padding-right: 30px;
					padding-left: 30px;
				}
			}
			@media screen and (min-width: 1218px) {
				.twentyfourteen .tfwc {
					margin-right: 54px;
				}
			}
		</style>
	<?php
		}
	}
add_theme_support( 'woocommerce' );
}
