<?php

namespace WebpConverter\Loader;

use WebpConverter\Conversion\Format\FormatFactory;
use WebpConverter\PluginData;

/**
 * Abstract class for class that supports method of loading images.
 */
abstract class LoaderAbstract implements LoaderInterface {

	const ACTION_NAME = 'webpc_refresh_loader';

	/**
	 * @var PluginData .
	 */
	protected $plugin_data;

	/**
	 * @param PluginData $plugin_data .
	 */
	public function __construct( PluginData $plugin_data ) {
		$this->plugin_data = $plugin_data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function init_hooks() {
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_mime_types(): array {
		$settings = $this->plugin_data->get_plugin_settings();
		return ( new FormatFactory() )->get_mime_types( $settings['output_formats'] );
	}
}
