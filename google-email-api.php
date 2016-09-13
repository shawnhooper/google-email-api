<?php
/*
Plugin Name: Google E-Mail API
Description: Integrates the Google E-Mail API into WordPress.
Version: 1.0.4
Author: Shawn Hooper, Actionable
*/

require_once( 'vendor/autoload.php');

class GoogleEmailAPIPlugin {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'settings_menu_item' ) );
		add_action( 'admin_init', array( $this, 'settings_init' ) );
	}

	function settings_menu_item() {
		add_options_page(
			'Google E-Mail API',
			'Google E-Mail API',
			'manage_options',
			'google-email-api',
			array( $this, 'settings_page' )
		);
	}

	function settings_page() {
		?>
		<div class="wrap">

			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

			<div id="poststuff">
				<div id="post-body">
					<div id="post-body-content">
						<form method="post" action="options.php">
							<?php settings_fields( 'google-email-api' );
							do_settings_sections( 'google-email-api' );
							submit_button(); ?>
						</form>
					</div> <!-- end post-body-content -->
				</div> <!-- end post-body -->
			</div> <!-- end poststuff -->
		</div>
		<?php
	}

	function settings_init() {
		add_settings_section(
			'google_email_api_key_section',
			'API Key',
			array( $this, 'api_key_section_callback' ),
			'google-email-api'
		);

		add_settings_field(
			'google_email_api_key',
			'Key',
			array( $this, 'google_email_api_key_callback' ),
			'google-email-api',
			'google_email_api_key_section'
		);

		add_settings_field(
			'google_email_api_secret',
			'Key',
			array( $this, 'google_email_api_secret_callback' ),
			'google-email-api',
			'google_email_api_key_section'
		);

		register_setting( 'google-email-api', 'google_email_api_key' );
		register_setting( 'google-email-api', 'google_email_api_secret' );
	}

	function api_key_section_callback() {
		echo '<p>A valid Google E-Mail API Key is required in order for this plugin to function properly.</p>';
	}

	function google_email_api_key_callback() {
		$setting = esc_attr( get_option( 'google_email_api_key' ) );
		echo "<input type='text' name='google_email_api_key' size='50' value='$setting' />";
	}

	function google_email_api_secret_callback() {
		$setting = esc_attr( get_option( 'google_email_api_secret' ) );
		echo "<input type='text' name='google_email_api_secret' size='50' value='$setting' />";
	}

}

$googleEmailAPIPlugin = new GoogleEmailAPIPlugin();
