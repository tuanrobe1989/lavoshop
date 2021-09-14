<?php

namespace WebpConverter\Conversion;

use WebpConverter\Conversion\Format\FormatFactory;
use WebpConverter\HookableInterface;
use WebpConverter\PluginData;

/**
 * Removes from list of source file paths those that have already been converted.
 */
class SkipExists implements HookableInterface {

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
	public function init_hooks() {
		add_filter( 'webpc_files_paths', [ $this, 'skip_exists_images' ], 10, 2 );
	}

	/**
	 * Removes from list of image paths those that have already been converted to output formats.
	 *
	 * @param string[] $paths       Server paths of source images.
	 * @param bool     $skip_exists Delete images already converted?
	 *
	 * @return string[] Server paths of source images.
	 * @internal
	 */
	public function skip_exists_images( array $paths, bool $skip_exists = true ): array {
		if ( ! $skip_exists ) {
			return $paths;
		}

		$directory  = new OutputPath();
		$extensions = $this->get_output_extensions();
		foreach ( $paths as $key => $path ) {
			$output_paths = $directory->get_paths( urldecode( $path ), false, $extensions );
			$is_exists    = true;
			foreach ( $output_paths as $output_path ) {
				if ( ! file_exists( $output_path )
					&& ! file_exists( $output_path . '.' . SkipLarger::DELETED_FILE_EXTENSION ) ) {
					$is_exists = false;
				}
			}

			if ( $is_exists ) {
				unset( $paths[ $key ] );
			}
		}
		return $paths;
	}

	/**
	 * Returns list of file extensions in output directory.
	 *
	 * @return string[] Available output extensions.
	 */
	private function get_output_extensions(): array {
		$settings   = $this->plugin_data->get_plugin_settings();
		$extensions = ( new FormatFactory() )->get_available_formats( $settings['method'] );

		$values = [];
		foreach ( $extensions as $extension => $format_label ) {
			$values[] = $extension;
		}
		return $values;
	}
}
