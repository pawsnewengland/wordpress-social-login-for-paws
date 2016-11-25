<?php

/**
 * Plugin Name: WordPress Social Login for PAWS
 * Plugin URI: https://github.com/pawsnewengland/wordpress-social-login-for-paws/
 * GitHub Plugin URI: https://github.com/pawsnewengland/wordpress-social-login-for-paws/
 * Description: Extends the <a href="https://wordpress.org/plugins/wordpress-social-login/">WordPress Social Login plugin</a>.
 * Version: 1.2.1
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * License: GPLv3
 */


// Get the plugin options
require_once( plugin_dir_path( __FILE__ ) . 'options.php' );



/**
 * Remove "Connect With" Label
 */
function wp_social_login_for_paws_alter_connect_with_label() {
	return;
}
add_filter( 'wsl_render_auth_widget_alter_connect_with_label', 'wp_social_login_for_paws_alter_connect_with_label' );



/**
 * Remove widget CSS
 */
function wp_social_login_for_paws_alter_widget_css() {
	return;
}
add_filter( 'wsl_render_auth_widget_alter_widget_css', 'wp_social_login_for_paws_alter_widget_css' );



/**
 * Edit Login URL
 */
function wp_social_login_for_paws_alter_provider_icon_markup( $provider_id, $provider_name, $authenticate_url ) {
	$options = wp_social_login_for_paws_get_theme_options();
	?>
	<p>
		<a rel="nofollow" href="<?php echo $authenticate_url; ?>" class="wp-social-login-provider wp-social-login-provider-<?php echo strtolower( $provider_id ); ?> <?php echo esc_attr( $options['login_class'] ); ?>" data-provider="<?php echo $provider_id ?>">
			<?php echo stripslashes( $options['login_text'] ); ?>
		</a>
	</p>
	<?php
}
add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'wp_social_login_for_paws_alter_provider_icon_markup', 10, 3 );



/**
 * Remove Stylesheet
 */
function wp_social_login_for_paws_remove_styles() {
	remove_action( 'wp_enqueue_scripts', 'wsl_add_stylesheets' );
	remove_action( 'login_enqueue_scripts', 'wsl_add_stylesheets' );
}
add_action( 'init', 'wp_social_login_for_paws_remove_styles' );



/**
 * Disable password resets
 */
function wp_social_login_for_paws_disable_password_reset( $text ) {
	return ( $text === 'Lost your password?' ? '' : $text );
}
add_filter( 'gettext', 'wp_social_login_for_paws_disable_password_reset' );
add_filter( 'show_password_fields', 'disable' );
add_filter( 'allow_password_reset', 'disable' );



/**
 * Change default login duration
 */
function wp_social_login_for_paws_change_default_login_length( $seconds, $user_id, $remember ) {

    // Change default expiration time to 2 hours
    $expiration = 60*60*2;

    // http://en.wikipedia.org/wiki/Year_2038_problem
    // Fix to a little bit earlier
    if ( PHP_INT_MAX - time() < $expiration ) {
        $expiration =  PHP_INT_MAX - time() - 5;
    }

    return $expiration;

}
add_filter( 'auth_cookie_expiration', 'wp_social_login_for_paws_change_default_login_length', 10, 3 );



/**
 * Add styling for admin SVG
 */
function wp_social_login_for_paws_admin_styles() {
	?>
	<style type="text/css">.wp-social-login-provider-list svg{display:inline-block;fill:currentColor;height:1em;width:1em;}.wp-social-login-provider-list{margin-bottom:1em;}</style>
	<?php
}
add_action( 'login_head', 'wp_social_login_for_paws_admin_styles' );