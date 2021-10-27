<?php

namespace WebpConverter\Conversion;

use WebpConverter\Conversion\Format\FormatFactory;
use WebpConverter\HookableInterface;
use WebpConverter\PluginData;
use WebpConverter\Settings\Option\ConversionMethodOption;

/**
 * Removes from list of source file paths those that have already been converted.
 */
class SkipConvertedPaths implements HookableInterface {

	/**
	 * @var PluginData
	 */
	private $plugin_data;

	public function __construct( PluginData $plugin_data ) {
		$this->plugin_data = $plugin_data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function init_hooks() {
		add_filter( 'webpc_supported_source_file', [ $this, 'skip_converted_path' ], 0, 4 );
	}

	/**
	 * Returns the status if the given file path should be converted.
	 *
	 * @param bool   $path_status    .
	 * @param string $filename       .
	 * @param string $server_path    .
	 * @param bool   $skip_converted Skip images already converted?
	 *
	 * @return bool Status if the given path has not been converted yet.
	 * @internal
	 */
	public function skip_converted_path( bool $path_status, string $filename, string $server_path, bool $skip_converted ): bool {
		if ( ! $skip_converted ) {
			return $path_status;
		}

		$directory    = new OutputPath();
		$extensions   = $this->get_output_extensions();
		$output_paths = $directory->get_paths( urldecode( $server_path ), false, $extensions );

		foreach ( $output_paths as $output_path ) {
			if ( file_exists( $output_path ) || file_exists( $output_path . '.' . SkipLarger::DELETED_FILE_EXTENSION ) ) {
				return false;
			}
		}

		return $path_status;
	}

	/**
	 * Returns list of file extensions in output directory.
	 *
	 * @return string[] Available output extensions.
	 */
	private function get_output_extensions(): array {
		$settings   = $this->plugin_data->get_plugin_settings();
		$extensions = ( new FormatFactory() )->get_available_formats( $settings[ ConversionMethodOption::OPTION_NAME ] ?? null );

		$values = [];
		foreach ( $extensions as $extension => $format_label ) {
			$values[] = $extension;
		}
		return $values;
	}
}
