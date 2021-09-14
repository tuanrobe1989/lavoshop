<?php

namespace WebpConverter\Conversion;

use WebpConverter\HookableInterface;
use WebpConverter\PluginData;

/**
 * Returns paths to files in given directory.
 */
class DirectoryFiles implements HookableInterface {

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
		add_filter( 'webpc_dir_files', [ $this, 'get_files_by_directory' ], 10, 3 );
	}

	/**
	 * Returns list of source images for directory.
	 *
	 * @param string[] $value       Server paths of source images.
	 * @param string   $dir_path    Server path of source directory.
	 * @param bool     $skip_exists Skip images already converted?
	 *
	 * @return string[] Server paths of source images.
	 * @internal
	 */
	public function get_files_by_directory( array $value, string $dir_path, bool $skip_exists = false ): array {
		if ( ! file_exists( $dir_path ) ) {
			return $value;
		}

		$settings = $this->plugin_data->get_plugin_settings();
		$excluded = apply_filters( 'webpc_dir_excluded', [] );

		$paths = $this->find_files_in_directory( $dir_path, $settings['extensions'], $excluded );
		return apply_filters( 'webpc_files_paths', $paths, $skip_exists );
	}

	/**
	 * Returns list of source images for directory.
	 *
	 * @param string   $dir_path      Server path of source directory.
	 * @param string[] $allowed_exts  File extensions to find.
	 * @param string[] $excluded_dirs Directories to ignore search.
	 *
	 * @return string[] Server paths of source images.
	 */
	private function find_files_in_directory( string $dir_path, array $allowed_exts, array $excluded_dirs ): array {
		$paths = scandir( $dir_path );
		$list  = [];
		if ( ! is_array( $paths ) ) {
			return $list;
		}

		foreach ( $paths as $path ) {
			if ( in_array( $path, $excluded_dirs ) ) {
				continue;
			}

			$current_path = $dir_path . '/' . urlencode( $path ); // phpcs:ignore
			if ( is_dir( $current_path ) ) {
				$list = array_merge( $list, $this->find_files_in_directory( $current_path, $allowed_exts, $excluded_dirs ) );
			} elseif ( in_array( strtolower( pathinfo( $current_path, PATHINFO_EXTENSION ) ), $allowed_exts ) ) {
				$list[] = $current_path;
			}
		}
		return $list;
	}
}
