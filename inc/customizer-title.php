<?php
/**
 * Control for Theme Title in admin panel
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
  * Customize Tagline
  *
  * Add upload logo, size and footer copyright in admin panel tagline
  *
  * @since Version 1.0
  * @author Adriano Giovannini <info@websources.it>
  * @links http://wwww.websources.it
  * @copyright Copyright (c) 2014, Adriano Giovannini
  * @license See http://opensource.org/licenses/gpl-license.php
  *
  * @package WordPress
  * @subpackage WebSources
  * @since WebSources 1.0
  */
function websources_title_customize_register() {

	global $wp_customize;
	
	// Overal Header
	$wp_customize->add_setting( 'maximum_header_height', 
		array( 
			'default' 		        => '240', 
			'sanitize_callback' 	        => 'absint' 
		) );
	$wp_customize->add_control( 'maximum_header_height', 
		array( 
			'label' 		        => __('Set Overall Header max-height (numbers only!) - Default is 240.','websources'), 
			'section' 		        => 'title_tagline', 
			'priority' 		        => 11, 
			'type' 			        => 'text', 
		) );
	//  Upload logo
	$wp_customize->add_setting('logo_image', array( 
		'default-image' 	 	        => '' 
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo', array( 
		'label' 			        => __( 'Upload a logo', 'websources' ), 
		'section'  			        => 'title_tagline', 
		'priority' 			        => 12, 
		'settings' 			        => 'logo_image', 
	) ) );
	
	// Add footer
	$wp_customize->add_setting(
                'copyright_footer',
                        array(
                                'default'                => __('Footer Copyright Message', 'websources' ),
                        )
                );
        
        $wp_customize->add_control(
                'copyright_footer',
                        array(
                                'label'                 => __( 'Type your footer copyright', 'websources' ),
                                'section'               => 'title_tagline',
                                'priority'              => 13,
                                'type'                  => 'text',
                        )
                );
}
add_filter( 'customize_register', 'websources_title_customize_register' );


