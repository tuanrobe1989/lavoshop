<?php


namespace WebpConverter\Settings\Page;

use WebpConverter\Error\Detector\RewritesErrorsDetector;
use WebpConverter\Helper\FileLoader;
use WebpConverter\Helper\ViewLoader;
use WebpConverter\Loader\LoaderAbstract;
use WebpConverter\Settings\SettingsSave;

/**
 * Supports debug tab in plugin settings page.
 */
class DebugPage extends PageAbstract {

	const PAGE_VIEW_PATH = 'views/settings-debug.php';

	/**
	 * {@inheritdoc}
	 */
	public function is_page_active(): bool {
		return ( isset( $_GET['action'] ) && ( $_GET['action'] === 'server' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	/**
	 * {@inheritdoc}
	 */
	public function show_page_view() {
		$uploads_url  = apply_filters( 'webpc_dir_url', '', 'uploads' );
		$uploads_path = apply_filters( 'webpc_dir_path', '', 'uploads' );
		$ver_param    = sprintf( 'ver=%s', time() );

		do_action( LoaderAbstract::ACTION_NAME, true, true );

		ViewLoader::load_view(
			self::PAGE_VIEW_PATH,
			[
				'settings_url'          => sprintf(
					'%1$s&%2$s=%3$s',
					PageIntegration::get_settings_page_url(),
					SettingsSave::NONCE_PARAM_KEY,
					wp_create_nonce( SettingsSave::NONCE_PARAM_VALUE )
				),
				'settings_debug_url'    => sprintf(
					'%s&action=server',
					PageIntegration::get_settings_page_url()
				),
				'size_png_path'         => FileLoader::get_file_size_by_path(
					$uploads_path . RewritesErrorsDetector::PATH_OUTPUT_FILE_PNG
				),
				'size_png2_path'        => FileLoader::get_file_size_by_path(
					$uploads_path . RewritesErrorsDetector::PATH_OUTPUT_FILE_PNG2
				),
				'size_png_url'          => FileLoader::get_file_size_by_url(
					$uploads_url . RewritesErrorsDetector::PATH_OUTPUT_FILE_PNG,
					$this->plugin_data,
					false,
					$ver_param
				),
				'size_png2_url'         => FileLoader::get_file_size_by_url(
					$uploads_url . RewritesErrorsDetector::PATH_OUTPUT_FILE_PNG2,
					$this->plugin_data,
					false,
					$ver_param
				),
				'size_png_as_webp_url'  => FileLoader::get_file_size_by_url(
					$uploads_url . RewritesErrorsDetector::PATH_OUTPUT_FILE_PNG,
					$this->plugin_data,
					true,
					$ver_param
				),
				'size_png2_as_webp_url' => FileLoader::get_file_size_by_url(
					$uploads_url . RewritesErrorsDetector::PATH_OUTPUT_FILE_PNG2,
					$this->plugin_data,
					true,
					$ver_param
				),
			]
		);

		do_action( LoaderAbstract::ACTION_NAME, true );
	}
}
