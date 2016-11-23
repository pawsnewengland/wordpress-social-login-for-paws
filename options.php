<?php

/**
 * Theme Options v1.1.0
 * Adjust theme settings from the admin dashboard.
 * Find and replace `wp_social_login_for_paws` with your own namepspacing.
 *
 * Created by Michael Fields.
 * https://gist.github.com/mfields/4678999
 *
 * Forked by Chris Ferdinandi
 * http://gomakethings.com
 *
 * Free to use under the MIT License.
 * http://gomakethings.com/mit/
 */


	/**
	 * Theme Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	function wp_social_login_for_paws_settings_field_login_text() {
		$options = wp_social_login_for_paws_get_theme_options();
		?>
		<input type="text" name="wp_social_login_for_paws_theme_options[login_text]" class="regular-text" id="login_text" value="<?php echo stripslashes( esc_attr( $options['login_text'] ) ); ?>">
		<label class="description" for="login_text"><?php _e( 'Text for the login button', 'wp_social_login_for_paws' ); ?></label>
		<?php
	}

	function wp_social_login_for_paws_settings_field_login_class() {
		$options = wp_social_login_for_paws_get_theme_options();
		?>
		<input type="text" name="wp_social_login_for_paws_theme_options[login_class]" class="regular-text" id="login_class" value="<?php echo esc_attr( $options['login_class'] ); ?>">
		<label class="description" for="login_class"><?php _e( 'Class for the login button', 'wp_social_login_for_paws' ); ?></label>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under wp_social_login_for_paws_get_theme_options(), and an if statement under wp_social_login_for_paws_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function wp_social_login_for_paws_get_theme_options() {
		$saved = (array) get_option( 'wp_social_login_for_paws_theme_options' );
		$defaults = array(
			'login_text' => 'Click Here to Login',
			'login_class' => '',
		);

		$defaults = apply_filters( 'wp_social_login_for_paws_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function wp_social_login_for_paws_theme_options_validate( $input ) {
		$output = array();

		if ( isset( $input['login_text'] ) && ! empty( $input['login_text'] ) )
			$output['login_text'] = wp_filter_post_kses( $input['login_text'] );

		if ( isset( $input['login_class'] ) && ! empty( $input['login_class'] ) )
			$output['login_class'] = wp_filter_nohtml_kses( $input['login_class'] );

		return apply_filters( 'wp_social_login_for_paws_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function wp_social_login_for_paws_theme_options_render_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'WordPress Social Login for PAWS Settings', 'wp_social_login_for_paws' ); ?></h2>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'wp_social_login_for_paws_options' );
					do_settings_sections( 'wp_social_login_for_paws_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function wp_social_login_for_paws_theme_options_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'wp_social_login_for_paws_options', 'wp_social_login_for_paws_theme_options', 'wp_social_login_for_paws_theme_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See wp_social_login_for_paws_theme_options_add_page().
		add_settings_section( 'general', null,  '__return_false', 'wp_social_login_for_paws_options' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'login_text', __( 'Login Text', 'wp_social_login_for_paws' ), 'wp_social_login_for_paws_settings_field_login_text', 'wp_social_login_for_paws_options', 'general' );
		add_settings_field( 'login_class', __( 'Login Class', 'wp_social_login_for_paws' ), 'wp_social_login_for_paws_settings_field_login_class', 'wp_social_login_for_paws_options', 'general' );

	}
	add_action( 'admin_init', 'wp_social_login_for_paws_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function wp_social_login_for_paws_theme_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		// $theme_page = add_theme_page( __( 'Theme Options', 'wp_social_login_for_paws' ), __( 'Theme Options', 'wp_social_login_for_paws' ), 'edit_theme_options', 'wp_social_login_for_paws_options', 'wp_social_login_for_paws_theme_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'wp_social_login_for_paws' ), __( 'Theme Options', 'wp_social_login_for_paws' ), 'edit_theme_options', 'wp_social_login_for_paws_options', 'wp_social_login_for_paws_theme_options_render_page' );
		$theme_page = add_submenu_page( 'options-general.php', __( 'WP Social Login for PAWS', 'wp_social_login_for_paws' ), __( 'WP Social Login for PAWS', 'wp_social_login_for_paws' ), 'edit_theme_options', 'wp_social_login_for_paws_options', 'wp_social_login_for_paws_theme_options_render_page' );
	}
	add_action( 'admin_menu', 'wp_social_login_for_paws_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function wp_social_login_for_paws_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_wp_social_login_for_paws_options', 'wp_social_login_for_paws_option_page_capability' );