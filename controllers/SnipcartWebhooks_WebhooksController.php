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
		        // This is an order:completed event
		        // do what needs to be done here.
		    	$this->processOrderCompletedEvent($body);
		    	break;
	    	default:
		    	$this->returnBadRequest(array('reason' => 'Unsupported event'));
	    		break;
		}
	}

	private function processOrderCompletedEvent($data) {
		$this->returnJson($data);
	}

	private function returnBadRequest($errors = array()) {
		header('HTTP/1.1 400 Bad Request');
		$this->returnJson(array('success' => false, 'errors' => $errors));
	}
}