<?php

namespace WebpConverter\Settings\Option;

use WebpConverter\Conversion\Method\MethodFactory;

/**
 * Handles data about "Conversion method" field in plugin settings.
 */
class ConversionMethodOption extends OptionAbstract {

	const LOADER_TYPE = 'method';

	/**
	 * Object of integration class supports all output formats.
	 *
	 * @var MethodFactory
	 */
	private $methods_integration;


	public function __construct() {
		$this->methods_integration = new MethodFactory();
	}

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
		return OptionAbstract::OPTION_TYPE_RADIO;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_label(): string {
		return __( 'Conversion method', 'webp-converter-for-media' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_info(): string {
		return __( 'The configuration for advanced users.', 'webp-converter-for-media' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values( array $settings ): array {
		return $this->methods_integration->get_methods();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_disabled_values( array $settings ): array {
		$methods           = $this->methods_integration->get_methods();
		$methods_available = $this->methods_integration->get_available_methods();
		return array_keys( array_diff( $methods, $methods_available ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value( array $settings = null ): string {
		$methods_available = $this->methods_integration->get_available_methods();
		return array_keys( $methods_available )[0] ?? '';
	}
}
