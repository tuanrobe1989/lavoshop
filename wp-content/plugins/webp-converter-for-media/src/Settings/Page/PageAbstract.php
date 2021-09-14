<?php

namespace WebpConverter\Settings\Page;

use WebpConverter\PluginData;

/**
 * Abstract class for class that supports tab in plugin settings page.
 */
abstract class PageAbstract implements PageInterface {

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
	 * Returns status if view is active.
	 *
	 * @return bool Is view active?
	 */
	public function is_page_active(): bool {
		return false;
	}
}
