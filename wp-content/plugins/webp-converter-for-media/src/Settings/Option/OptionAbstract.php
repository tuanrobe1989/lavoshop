<?php

namespace WebpConverter\Settings\Option;

/**
 * Abstract class for class that supports notice displayed in admin panel.
 */
abstract class OptionAbstract implements OptionInterface {

	const OPTION_TYPE_CHECKBOX = 'checkbox';
	const OPTION_TYPE_RADIO    = 'radio';
	const OPTION_TYPE_QUALITY  = 'quality';

	/**
	 * {@inheritdoc}
	 */
	public function get_info(): string {
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_disabled_values( array $settings ): array {
		return [];
	}

	/**
	 * Returns default value of field when debugging.
	 *
	 * @param mixed[] $settings Plugin settings.
	 *
	 * @return string|string[] Default value of field for debug.
	 */
	public function get_value_for_debug( array $settings ) {
		return $this->get_default_value( $settings );
	}
}
