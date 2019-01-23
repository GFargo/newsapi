<?php
/**
 * @TODO    : File Desc.
 *
 * @author  gfargo
 * @package NewsAPI
 */

namespace NewsAPI\Traits;

trait RemoteHeaders {
	/**
	 * HTTP Headers used with API requests.
	 *
	 * @var array
	 */
	protected $headers = [];

	/**
	 * @param array $headers
	 */
	public function setHeaders( $headers ): void {
		$this->headers = array_merge( $this->headers, $headers );
	}

	/**
	 * Retrieve all registered headers.
	 *
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}
}