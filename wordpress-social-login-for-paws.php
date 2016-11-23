<?php

/**
 * Plugin Name: WordPress Social Login for PAWS
 * Plugin URI: https://github.com/pawsnewengland/wordpress-social-login-for-paws/
 * GitHub Plugin URI: https://github.com/pawsnewengland/wordpress-social-login-for-paws/
 * Description: Extends the <a href="https://wordpress.org/plugins/wordpress-social-login/">WordPress Social Login plugin</a>.
 * Version: 1.0.0
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
	<a rel="nofollow" href="<?php echo $authenticate_url; ?>" class="wp-social-login-provider wp-social-login-provider-<?php echo strtolower( $provider_id ); ?> <?php echo esc_attr( $options['login_class'] ); ?>" data-provider="<?php echo $provider_id ?>">
		<?php echo stripslashes( $options['login_text'] ); ?>
	</a>
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