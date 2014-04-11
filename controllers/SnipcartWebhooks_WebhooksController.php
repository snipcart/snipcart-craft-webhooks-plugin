<?php

namespace Craft;

class SnipcartWebhooks_WebhooksController extends BaseController {
	
    protected $allowAnonymous = array('actionHandle');

	public function actionHandle() {
		$this->requirePostRequest();

		$json = file_get_contents('php://input');
		$body = json_decode($json, true);

		if (is_null($body) or !isset($body['eventName'])) {
			$this->returnBadRequest();
		    return;
		}

		switch ($body['eventName']) {
		    case 'order.completed':
		    	// We handle the order.completed event.
		    	$this->processOrderCompletedEvent($body);
		    	break;
	    	default:
		    	$this->returnBadRequest(array('reason' => 'Unsupported event'));
	    		break;
		}
	}

	private function returnBadRequest($errors = array()) {
		header('HTTP/1.1 400 Bad Request');
		$this->returnJson(array('success' => false, 'errors' => $errors));
	}

	private function processOrderCompletedEvent($data) {
		$content = $data['content'];
		$updated = array();
		
		foreach ($content['items'] as $item) {
			$entry = $this->updateItemQuantity($item);

			if ($entry != null) {
				$updated[] = $entry;
			}
		}

		$this->returnJson($updated);
	}
	
	private function updateItemQuantity($item) {
		$service = craft()->entries;

		$entry = $service->getEntryById($item['id']);

		if ($entry != null) {
			$attrs = $entry->getContent();

			$newQuantity = $attrs['quantity'] - $item['quantity'];

			$entry->getContent()->setAttributes(array(
				'quantity' => $newQuantity
			));

			$service->saveEntry($entry);

			return $entry;
		} else {
			return null;
		}
	}
}