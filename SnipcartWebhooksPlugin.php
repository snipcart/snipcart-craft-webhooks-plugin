<?php

namespace Craft;

class SnipcartWebhooksPlugin extends BasePlugin {
	public function getName() {
		return Craft::t('Snipcart Webhooks');
	}

	public function getVersion() {
		return '0.1';
	}

	public function getDeveloper() {
		return 'Snipcart';
	}

	public function getDeveloperUrl() {
		return 'https://snipcart.com';
	}
}