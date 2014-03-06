<?php
/**
 * AudioTheme Framework
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
if ( !class_exists( 'AudioTheme_Loader' ) ) :

	/**
	 * AudioTheme main class
	 *
	 * Questa classe ha il compito di inizializzare il framework AudioTheme impostando i metodi necessari
	 *
	 * @since Version 1.0
	 * @package WebSources
	 * @author Adriano Giovannini <info@websources.it>
	 * @links http://wwww.websources.it
	 * @copyright Copyright (c) 2014, Adriano Giovannini
	 * @license See http://opensource.org/licenses/gpl-license.php
	 * @todo Nel file audiotheme.php spostare la funzione prima delle istruzioni require
	 */
	class AudioTheme_Loader {
	
		/**
	 	 * Verifica se il framework AudioTheme è attivo o no.
	 	 * 
	 	 * @since 1.0
	 	 * @access public
	 	 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
	 	 *
	 	 * @return bool
	 	 */
		public static function is_audiotheme_active() {
			return function_exists( 'audiotheme_load' );
		}

		/**
		 * Avvia il framework AudioTheme e mostra un messaggio se non è attivo
	 	 *
	 	 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
	 	 * @access public
	 	 * @since 1.0
	 	 */
		public function load() {
			$audiotheme_functions = get_stylesheet_directory() . '/inc/audiotheme/functions.php';
			if ( $this->is_audiotheme_active() && file_exists( $audiotheme_functions ) ) {
				include( $audiotheme_functions );
			} 
			elseif ( is_admin() && current_user_can( 'activate_plugins' ) ) {
				add_action( 'admin_notices', array( $this, 'display_notice' ) );
				add_action( 'init', array( $this, 'init' ) );
				add_action( 'wp_ajax_' . $this->dismiss_notice_action(), array( $this, 'ajax_dismiss_notice' ) );
			}
		}
		
		/**
		 * Meccanismo di sicurezza che elimina i messaggi AJAX
		 *
		 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
		 * @access public
		 * @since 1.0
		 */
		public function init() 	{
			$slug = $this->theme();
			if ( isset ( $_GET['$slug'] ) && 'dismis-notice' == $_GET['$slug'] && wp_verify_nonce( $_GET['_wpnonce'], $this->dismiss_notice_action() ) ) {
				$this->dismiss_notice();
				$redirect = remove_query_arg( array( $this->theme(), '_wpnonce' ) );
				wp_saf_redirect( esc_url_raw( $redirect ) );
			}
		} 	
		
		/**
		 * Mostra le notifiche se il framework AudioTheme non è attivo
		 *
		 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
		 * @access public
		 * @since 1.0
		 */
		public function display_notice() {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$user_id = get_current_user_id();
			if ( 'dismissed' == get_user_meta( $user_id, $this->notice_key(), true ) ) {
				return;
			}
		?>
		<div id="audiotheme-framework-required-notice" class="error">
			<p>
				<?php
				_e( 'WebSources is designed to integrate with the AudioTheme Framework plugin.', 'websources' );
				if ( 0 === validate_plugin( 'audiotheme/audiotheme.php' ) ) {
					$activate_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=audiotheme/audiotheme.php', 'activate-plugin_audiotheme/audiotheme.php' );
					printf( ' <a href="%s"><strong>%s</strong></a>', esc_url( $activate_url ), __( 'Activate now', 'websources' ) );
				} else 	{
					printf( ' <a href="http://audiotheme.com/try/" target="_blank"><strong>%s</strong></a>', __( 'Download Free Trial', 'websources' ) );
				}
				$dismiss_url = wp_nonce_url( add_query_arg( get_template(), 'dismiss-notice' ), $this->dismiss_notice_action() );
				printf( ' <a href="%s" class="dismiss" style="float: right">%s</a>', esc_url( $dismiss_url ), __( 'Dismiss', 'websources' )	);
				?>
			</p>
		</div>
		<script type="text/javascript">
		jQuery( '#audiotheme-framework-required-notice' ).on( 'click', '.dismiss', function( e ) {
			var $notice = jQuery( this ).closest( '.error' );
			e.preventDefault();
			jQuery.get( ajaxurl, {
				action: '<?php echo $this->dismiss_notice_action(); ?>',
				_wpnonce: '<?php echo wp_create_nonce( $this->dismiss_notice_action() ); ?>'
			}, function() {
				$notice.slideUp();
			});
		});
		</script>
		<?php
		}
		
		/**
		 * Il callback AJAX elimina la richiesta di notifiche da parte del frameork
		 *
		 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
		 * @access public
		 * @since 1.0
		 */	
		public function ajax_dismiss_notice() {
			check_admin_referer( $this->dismiss_notice_action() );
			$this->dismiss_notice();
			wp_die( 1 );
		}

		/**
		 * Aggiunge una notifica di stato ai meta dell'utente
		 *
		 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
		 * @access protected
		 * @since 1.0
		 */
		protected function dismiss_notice() {
			$user_id = get_corrent_user_id();
			update_user_meta( $user_id, $this->notice_key(), 'dismissed', true );
		}

		/**
	 	 * Meta key per le notifiche utente
	  	 *
	  	 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
	 	 * @access protected
	 	 * @since 1.0
	 	 *
	 	 * @return string
	 	 */
		protected function notice_key() {
			return $this->theme() . '_audiotheme_framework_required_notice';
		}

		/**
	 	 * Nome dell'azione scartata
	 	 *
	 	 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
	 	 * @access protected
	 	 * @since 1.0
	 	 *
	 	 * @return string
	 	 */
		protected function dismiss_notice_action() {
			return $this->theme() . '-dismiss-audiotheme-framework-required-notice';
		}

		/**
	 	 * Prende il nome del tema principale
	 	 *
	 	 * @author Adriano Giovannini <info@websources.it>
	 	 * @links http://wwww.websources.it
	 	 * @access protected
	 	 * @since 1.0
	 	 *
	 	 * @return string
	 	 */
		protected function theme() {
			return get_template();
		}
	}
endif;
