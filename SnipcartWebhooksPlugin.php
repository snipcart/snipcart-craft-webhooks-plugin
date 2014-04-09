<?php

namespace Craft;

class SnipcartWebhooksPlugin extends BasePlugin {
	function getName() {
		return Craft::t('Snipcart Webhooks');
	}

	function getVersion() {
		return '0.1';
	}

	function getDeveloper() {
		return 'Snipcart';
	}

	function getDeveloperUrl() {
		return 'https://snipcart.com';
	}
}