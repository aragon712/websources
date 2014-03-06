<?php
/**
 * Wrapper for AudioTheme
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
require get_stylesheet_directory() . '/inc/template-tags.php';
require get_stylesheet_directory() . '/functions/audiotheme/hook.php';
require get_stylesheet_directory() . '/functions/audiotheme/class.audiothemeloader.php';

$obj_audiotheme = new AudioTheme_Loader();
$obj_audiotheme->load();

/**
 * Register Taxonomy for AudioTheme plugin
 *
 * @since Version 1.0
 * @author Adriano Giovannini <info@websources.it>
 * @links http://wwww.websources.it
 * @copyright Copyright (c) 2014, Adriano Giovannini
 * @license See http://opensource.org/licenses/gpl-license.php
 */
function websources_init() {
	register_taxonomy_for_object_type( 'post_tag', 'audiotheme_record' );
}
add_action( 'add_init', 'websources_init' );
