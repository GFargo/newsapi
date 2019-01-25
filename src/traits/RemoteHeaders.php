<?php
/**
 * Interface for Remote API Headers
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 */

namespace NewsAPI\Traits;

trait RemoteHeaders {
	/**
	 * HTTP Headers used for remote requests.
	 *
	 * Each remote is stored as a key value pair, the key being the slug while
	 * the value stored is the URL of the target endpoint.
	 *
	 * @var array
	 */
	protected $headers = [];

	/**
	 * Set Request Headers.
	 *
	 * @param array $headers HTTP headers
	 *
	 * @return void
	 */
	public function setHeaders( $headers ): void {
		$this->headers = array_merge( $this->headers, $headers );
	}

	/**
	 * Retrieve all registered headers.
	 *
	 * @return array Headers used in requests to API.
	 */
	public function getHeaders() {
		return $this->headers;
	}
}
