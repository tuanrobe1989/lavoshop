<?php


namespace WebpConverter\Settings\Page;

use WebpConverter\Conversion\Endpoint\PathsEndpoint;
use WebpConverter\Conversion\Endpoint\RegenerateEndpoint;
use WebpConverter\Helper\ViewLoader;
use WebpConverter\Loader\LoaderAbstract;
use WebpConverter\Settings\Option\OptionFactory;
use WebpConverter\Settings\SettingsSave;

/**
 * Supports default tab in plugin settings page.
 */
class SettingsPage extends PageAbstract {

	const PAGE_VIEW_PATH = 'views/settings.php';

	/**
	 * {@inheritdoc}
	 */
	public function is_page_active(): bool {
		return ( ! isset( $_GET['action'] ) || ( $_GET['action'] !== 'server' ) ); // phpcs:ignore
	}

	/**
	 * {@inheritdoc}
	 */
	public function show_page_view() {
		( new SettingsSave( $this->plugin_data ) )->save_settings();

		ViewLoader::load_view(
			self::PAGE_VIEW_PATH,
			[
				'errors_messages'    => apply_filters( 'webpc_server_errors_messages', [] ),
				'errors_codes'       => apply_filters( 'webpc_server_errors', [] ),
				'options'            => ( new OptionFactory() )->get_options(),
				'submit_value'       => SettingsSave::SUBMIT_VALUE,
				'settings_url'       => sprintf(
					'%1$s&%2$s=%3$s',
					PageIntegration::get_settings_page_url(),
					SettingsSave::NONCE_PARAM_KEY,
					wp_create_nonce( SettingsSave::NONCE_PARAM_VALUE )
				),
				'settings_debug_url' => sprintf(
					'%s&action=server',
					PageIntegration::get_settings_page_url()
				),
				'api_paths_url'      => ( new PathsEndpoint( $this->plugin_data ) )->get_route_url(),
				'api_regenerate_url' => ( new RegenerateEndpoint( $this->plugin_data ) )->get_route_url(),
			]
		);

		do_action( LoaderAbstract::ACTION_NAME, true );
	}
}
