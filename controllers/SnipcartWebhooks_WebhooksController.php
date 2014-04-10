<?php

namespace Craft;

class SnipcartWebhooks_WebhooksController extends BaseController {
	
    protected $allowAnonymous = true;

	public function actionPost() {
		$this->requirePostRequest();
		$json = file_get_contents('php://input');
		$body = json_decode($json, true);

		$this->returnJson($json);
		if (is_null($body) or !isset($body['eventName'])) {
		    // When something goes wrong, return an invalid status code
		    // such as 400 BadRequest.
		    header('HTTP/1.1 400 Bad Request');
		    return;
		}

		switch ($body['eventName']) {
		    case 'order.completed':
		        // This is an order:completed event
		        // do what needs to be done here.
		    	$this->processOrderCompletedEvent($body);
		    	break;
		}
	}

	private function processOrderCompletedEvent($data) {
		$this->returnJson($data);
	}
}