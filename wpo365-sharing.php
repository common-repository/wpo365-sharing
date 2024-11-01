<?php
/**
 * Plugin Name:     WPO365 | SHARING
 * Description:     With WPO365 | SHARING website visitors can share a link directly from the website to any person and / or Microsoft Teams channel / Yammer group.
 * Version:         1.0.0
 * Author:          support@wpo365.com
 * Author URI:      https://www.wpo365.com
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     wpo365-sharing
 */

namespace Wpo;

if ( !class_exists( '\Wpo\Sharing' ) ) {

    class Sharing {

        public function __construct() {
            $this->hook_up();
        }

        private function hook_up() {
            /**
             * Ensure the rendering of the social buttons through a shortcode.
             */
            add_action( 'init', '\Wpo\Sharing::ensure_social_buttons_short_code' );

            /**
             * Show admin notices.
             */
            add_action( 'admin_notices', '\Wpo\Sharing::show_admin_notices', 10, 0 );
            add_action( 'network_admin_notices', '\Wpo\Sharing::show_admin_notices', 10, 0 );
            add_action( 'admin_init', '\Wpo\Sharing::dismiss_admin_notices', 10, 0 );
        }

        /**
         * Helper method to ensure that the wpo365-social-buttons shortcode is initialized.
         * 
         * @since 1.0.0
         * 
         * @return void
         */
        public static function ensure_social_buttons_short_code() {
            wp_enqueue_script( 'teams-launcher', 'https://teams.microsoft.com/share/launcher.js', array(), '1.0.0' );
            wp_enqueue_script( 'yammer-launcher', 'https://s0.assets-yammer.com/assets/platform_social_buttons.min.js', array(), '1.0.0' );
            wp_add_inline_script( 'yammer-launcher', 'document.addEventListener("DOMContentLoaded", function(event) { shareToMicrosoftTeams.renderButtons(); if (typeof yam != "undefined") { yam.platform.yammerShare(); } })' );

            if ( ! shortcode_exists( 'wpo365-social-buttons' ) ) {
                add_shortcode( 'wpo365-social-buttons', '\Wpo\Sharing::social_buttons_short_code' );
            }
        }
        /**
         * Implementation of the wpo365-social-buttons shortcode. 
         * 
         * @since 1.0.0
         * 
         * @param array     $atts       Short code parameters according to Wordpress codex
         * @param string    $content    Found in between the short code start and end tag
         * @param string    $tag        Text domain
         */
        public static function social_buttons_short_code( $atts = array(), $content = null, $tag = '' ) {
            global $wp;

            $atts = array_change_key_case( (array)$atts, CASE_LOWER);
            
            $current_url = home_url( add_query_arg( array(), $wp->request ) );
            
            // Whether or not to render either button
            $stt = isset( $atts[ 'stt' ] ) && filter_var( $atts[ 'stt' ], FILTER_VALIDATE_BOOLEAN ); 
            $sty = isset( $atts[ 'sty' ] ) && filter_var( $atts[ 'sty' ], FILTER_VALIDATE_BOOLEAN );
            
            ob_start();
            include( __DIR__ . '/templates/social-buttons.php' );
            $content = ob_get_clean();
            
            return $content;
        }

        /**
         * Shows admin notices.
         * 
         * @since   1.0.0
         * 
         * @return  void
         */
        public static function show_admin_notices() {

            if ( !is_admin() && !is_network_admin() ) {
                return;
            }

            if ( false === get_transient( 'wpo365_sharing_review_dismissed' ) ) {
                echo( '<div class="notice notice-info" style="margin-left: 2px;"><p>' 
                    . sprintf( __( 'Many thanks for using the %s plugin! Could you please spare a minute and give it a review over at WordPress.org?', 'wpo365-sharing' ), '<strong>WPO365 | SHARING</strong>' )
                    . '</p><p>With <a href="https://wordpress.org/plugins/wpo365-login/" target="_blank">WPO365 | LOGIN</a> users can sign in with their corporate or school (Azure AD / Microsoft Office 365) account to access your WordPress internet / intranet / extranet website: No username or password required.</p>'
                    . '<p><a class="button button-primary" href="http://wordpress.org/support/view/plugin-reviews/wpo365-sharing?filter=5#postform" target="_blank">' . __( 'Yes, here we go!', 'wpo365-sharing' ) . '</a> <a class="button" href="./?wpo365_sharing_review_dismissed">' . __( 'Remind me later', 'wpo365-sharing' ) . '</a></p>'
                    . '<p>- Marco van Wieren | Downloads by van Wieren | <a target="_blank" href="https://www.wpo365.com/">https://www.wpo365.com/</a></p></div>' );
            }
        }

        /**
         * Helper to configure a transient to surpress admin notices when the user clicked dismiss.
         * 
         * @since   1.0.0
         * 
         * @return  void
         */
        public static function dismiss_admin_notices() {

            if ( isset( $_GET[ 'wpo365_sharing_review_dismissed' ] ) ) {
                set_transient( 'wpo365_sharing_review_dismissed', date( 'd' ), 2419200 );
            }
        }
    }

    // Safe to initialize the plugin
    new Sharing();
}
