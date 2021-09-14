<?php

namespace WebpConverter\Action;

use WebpConverter\Conversion\Method\MethodIntegrator;
use WebpConverter\HookableInterface;
use WebpConverter\PluginData;

/**
 * Initializes conversion of all images in list of paths.
 */
class ConvertPaths implements HookableInterface {

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
		add_action( 'webpc_convert_paths', [ $this, 'convert_files_by_paths' ] );
	}

	/**
	 * Converts all given images to output formats.
	 *
	 * @param string[] $paths Server paths of images.
	 *
	 * @return void
	 * @internal
	 */
	public function convert_files_by_paths( array $paths ) {
		( new MethodIntegrator( $this->plugin_data ) )
			->init_conversion( $this->remove_paths_of_excluded_dirs( $paths ) );
	}

	/**
	 * Removes paths of source images in excluded directories.
	 *
	 * @param string[] $paths Server paths of images.
	 *
	 * @return string[] Server paths of images.
	 */
	private function remove_paths_of_excluded_dirs( array $paths ): array {
		$excluded_dirs = apply_filters( 'webpc_dir_excluded', [] );
		foreach ( $paths as $path_index => $path ) {
			foreach ( $excluded_dirs as $excluded_dir ) {
				$dir_pattern = str_replace( '.', '\.', $excluded_dir );
				if ( ! preg_match( '/(\\\\|\/)(' . $dir_pattern . ')(\\\\|\/)/', $path ) ) {
					continue;
				}
				unset( $paths[ $path_index ] );
				break;
			}
		}
		return $paths;
	}
}
