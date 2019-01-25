<?php
/**
 * PHPUnit Bootstrap File.
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 */

// Include composer autoloader.
require  dirname( dirname( dirname( __FILE__ ) ) ) . '/vendor/autoload.php' ;

/**
 * NewsAPIMockTransport Test Class
 *
 * Mock class that allows the testing of requests made by the `query` method.
 */
class NewsAPIMockTransport implements \Requests_Transport {
	public $code = 200;
	public $chunked = false;
	public $body = 'Test Body';
	public $raw_headers = '';

	private static $messages = [
		200 => '200 OK',
		301 => '301 Moved Permanently',
		302 => '302 Found',
		400 => '400 Bad Request',
		401 => '401 Unauthorized',
		403 => '403 Forbidden',
		404 => '404 Not Found',
		500 => '500 Internal Server Error',
		502 => '502 Bad Gateway',
		503 => '503 Service Unavailable',
		504 => '504 Gateway Timeout',
	];

	public function request( $url, $headers = [], $data = [], $options = [] ) {
		$status   = isset( self::$messages[ $this->code ] ) ? self::$messages[ $this->code ] : $this->code . ' unknown';
		$response = "HTTP/1.0 $status\r\n";
		$response .= "Content-Type: text/plain\r\n";
		if ( $this->chunked ) {
			$response .= "Transfer-Encoding: chunked\r\n";
		}
		$response .= $this->raw_headers;
		$response .= "Connection: close\r\n\r\n";
		$response .= $this->body;

		return $response;
	}

	public function request_multiple( $requests, $options ) {
		$responses = [];
		foreach ( $requests as $id => $request ) {
			$handler              = new MockTransport();
			$handler->code        = $request['options']['mock.code'];
			$handler->chunked     = $request['options']['mock.chunked'];
			$handler->body        = $request['options']['mock.body'];
			$handler->raw_headers = $request['options']['mock.raw_headers'];
			$responses[ $id ]     = $handler->request( $request['url'], $request['headers'], $request['data'], $request['options'] );

			if ( ! empty( $options['mock.parse'] ) ) {
				$request['options']['hooks']->dispatch( 'transport.internal.parse_response', [
					&$responses[ $id ],
					$request,
				] );
				$request['options']['hooks']->dispatch( 'multiple.request.complete', [ &$responses[ $id ], $id ] );
			}
		}

		return $responses;
	}

	public static function test() {
		return true;
	}
}
