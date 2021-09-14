<?php

namespace WebpConverter\Conversion\Method;

use WebpConverter\Conversion\Exception;
use WebpConverter\Conversion\OutputPath;
use WebpConverter\Conversion\SkipLarger;

/**
 * Abstract class for class that supports endpoint.
 */
abstract class MethodAbstract implements MethodInterface {

	/**
	 * Messages of errors that occurred during conversion.
	 *
	 * @var string[]
	 */
	private $errors = [];

	/**
	 * Sum of size of source images before conversion.
	 *
	 * @var int
	 */
	private $size_before = 0;

	/**
	 * Sum of size of output images after conversion.
	 *
	 * @var int
	 */
	private $size_after = 0;

	/**
	 * {@inheritdoc}
	 */
	public function get_errors(): array {
		return $this->errors;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_size_before(): int {
		return $this->size_before;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_size_after(): int {
		return $this->size_after;
	}

	/**
	 * {@inheritdoc}
	 */
	public function convert_paths( array $paths, array $plugin_settings ) {
		$output_formats = $plugin_settings['output_formats'];
		foreach ( $output_formats as $output_format ) {
			foreach ( $paths as $path ) {
				try {
					$response = $this->convert_path( $path, $output_format, $plugin_settings );

					$this->size_before += $response['data']['size_before'];
					$this->size_after  += $response['data']['size_after'];
				} catch ( \Exception $e ) {
					$this->errors[] = $e->getMessage();
				}
			}
		}
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws Exception\OutputPathException
	 * @throws Exception\SourcePathException
	 */
	public function convert_path( string $path, string $format, array $plugin_settings ): array {
		ini_set( 'memory_limit', '1G' ); // phpcs:ignore
		if ( strpos( ini_get( 'disable_functions' ) ?: '', 'set_time_limit' ) === false ) {
			set_time_limit( 120 );
		}

		try {
			$source_path = $this->get_image_source_path( $path );
			$image       = $this->create_image_by_path( $source_path, $plugin_settings );
			$output_path = $this->get_image_output_path( $source_path, $format );

			if ( file_exists( $output_path . '.' . SkipLarger::DELETED_FILE_EXTENSION ) ) {
				unlink( $output_path . '.' . SkipLarger::DELETED_FILE_EXTENSION );
			}

			$this->convert_image_to_output( $image, $source_path, $output_path, $format, $plugin_settings );
			do_action( 'webpc_convert_after', $output_path, $source_path );

			return [
				'success' => true,
				'message' => null,
				'data'    => $this->get_conversion_stats( $source_path, $output_path ),
			];
		} catch ( \Exception $e ) {
			$features = $plugin_settings['features'] ?? [];
			if ( in_array( 'debug_enabled', $features ) ) {
				error_log( sprintf( 'WebP Converter for Media: %s', $e->getMessage() ) ); // phpcs:ignore
			}

			throw $e;
		}
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws Exception\SourcePathException
	 */
	public function get_image_source_path( string $source_path ): string {
		$path = urldecode( $source_path );
		if ( ! is_readable( $path ) ) {
			throw new Exception\SourcePathException( $path );
		}

		return $path;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws Exception\OutputPathException
	 */
	public function get_image_output_path( string $source_path, string $format ): string {
		if ( ! $output_path = OutputPath::get_path( $source_path, true, $format ) ) {
			throw new Exception\OutputPathException( $source_path );
		}

		return $output_path;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_conversion_stats( string $source_path, string $output_path ): array {
		$size_before = filesize( $source_path );
		$size_after  = ( file_exists( $output_path ) ) ? filesize( $output_path ) : $size_before;

		return [
			'size_before' => $size_before ?: 0,
			'size_after'  => $size_after ?: 0,
		];
	}
}
