<?php

namespace WebpConverter\Settings\Option;

/**
 * Handles data about "Supported files extensions" field in plugin settings.
 */
class SupportedExtensionsOption extends OptionAbstract {

	const LOADER_TYPE = 'extensions';

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
		return __( 'List of supported files extensions', 'webp-converter-for-media' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values( array $settings ): array {
		return [
			'jpg'  => '.jpg',
			'jpeg' => '.jpeg',
			'png'  => '.png',
			'gif'  => '.gif',
		];
	}

	/**
	 * Returns default value of field.
	 *
	 * @param mixed[]|null $settings Plugin settings.
	 *
	 * @return string[] Default value of field.
	 */
	public function get_default_value( array $settings = null ): array {
		return [ 'jpg', 'jpeg', 'png' ];
	}

	/**
	 * Returns default value of field when debugging.
	 *
	 * @param mixed[] $settings Plugin settings.
	 *
	 * @return string[] Default value of field for debug.
	 */
	public function get_value_for_debug( array $settings ): array {
		return [ 'png2', 'png' ];
	}
}
