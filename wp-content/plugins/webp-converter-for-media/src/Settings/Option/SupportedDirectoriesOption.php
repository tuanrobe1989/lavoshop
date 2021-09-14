<?php

namespace WebpConverter\Settings\Option;

use WebpConverter\Conversion\Directory\DirectoryFactory;

/**
 * Handles data about "Supported directories" field in plugin settings.
 */
class SupportedDirectoriesOption extends OptionAbstract {

	const LOADER_TYPE = 'dirs';

	/**
	 * {@inheritdoc}
	 */
	public function get_name(): string {
		return self::LOADER_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_type(): string {
		return OptionAbstract::OPTION_TYPE_CHECKBOX;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label(): string {
		return __( 'List of supported directories', 'webp-converter-for-media' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_info(): string {
		return __( 'Files from these directories will be supported in output formats.', 'webp-converter-for-media' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values( array $settings ): array {
		return ( new DirectoryFactory() )->get_directories();
	}

	/**
	 * Returns default value of field.
	 *
	 * @param mixed[]|null $settings Plugin settings.
	 *
	 * @return string[] Default value of field.
	 */
	public function get_default_value( array $settings = null ): array {
		return [ 'uploads' ];
	}

	/**
	 * Returns default value of field when debugging.
	 *
	 * @param mixed[] $settings Plugin settings.
	 *
	 * @return string[] Default value of field for debug.
	 */
	public function get_value_for_debug( array $settings ): array {
		return [ 'uploads' ];
	}
}
