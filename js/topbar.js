/** 
 * Topbat
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
jQuery(document).ready(function($) {
        var social      = '.topbar-description';
        var nav         = 'nav#primary-navigation';
        var headerMain  = '.header-main';
        var header      = '#masthead';
        var main        = '#main';
        var mastFix = function() {
                $(header).css({
                        marginTop: $('#wpadminbar').height() + 'px'
                });
        };
        mastFix();
        $('#wpadminbar').css( 'position', 'fixed' );
        $(function(){
                $(header).data('size','big');
        });
        $(window).scroll(function(){
                var $nav = $(header);
                if ($('body').scrollTop() || $('html').scrollTop() > 0) {
                        if ($nav.data('size') == 'big') {
                                mastFix();
                                $( social ).css('display', 'none');
                                $( nav ).css({
                                        display: 'inline',
                                        top: '0px',
                                });
                                $( headerMain ).fadeOut("fast");
                                $( nav ).animate({
                                        paddingLeft: $( 'h1.site-title' ).width() + 70 + 'px',
                                }), {queue:false, duration:600};
                                $( nav ).css('top', '0px');
                                $nav.data('size','small').stop().animate({
                                        height:'48px'
                                }, 600);
                                $( headerMain ).animate({
                                        left:200, opacity:"show"}, 600);
                        }
                } else {
                        if ($nav.data('size') == 'small') {
                                mastFix();
                                $( social ).css('display', 'inline');
                                $( nav ).animate({
                                        display: 'block',
                                        top: '40px',
                                }), {queue:false, duration:600}; ;
                                $( nav ).animate({
                                        paddingLeft: '30px',
                                }), {queue:false, duration:600};
                                $nav.data('size','big').stop().animate({
                                        height:'88px'
                                }, 600);
                        }
                }
        });
        var marginFix = function() {
                $(main).css({
                        marginTop: $(header).height() + 'px',
                });
        };
        marginFix();
        $( window ).resize(function() {
                marginFix();
                mastFix();
        });
}); //end jQuery noConflict wrapper
