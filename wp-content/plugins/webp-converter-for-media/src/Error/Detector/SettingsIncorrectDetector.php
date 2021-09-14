<?php

namespace WebpConverter\Error\Detector;

use WebpConverter\Error\Notice\SettingsIncorrectNotice;
use WebpConverter\PluginData;

/**
 * Checks for configuration errors about incorrectly saved plugin settings.
 */
class SettingsIncorrectDetector implements ErrorDetector {

	/**
	 * @var PluginData .
	 */
	private $plugin_data;

	/**
	 * @param PluginData $plugin_data .
	 */
	public function __construct( PluginData $plugin_data ) {
		$this->plugin_data = $plugin_data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error() {
		$settings = $this->plugin_data->get_plugin_settings();

		if ( ( ! isset( $settings['extensions'] ) || ! $settings['extensions'] )
			|| ( ! isset( $settings['dirs'] ) || ! $settings['dirs'] )
			|| ( ! isset( $settings['method'] ) || ! $settings['method'] )
			|| ( ! isset( $settings['output_formats'] ) || ! $settings['output_formats'] )
			|| ( ! isset( $settings['quality'] ) || ! $settings['quality'] ) ) {
			return new SettingsIncorrectNotice();
		}

		return null;
	}
}
