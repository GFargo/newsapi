<?php
/**
 * Interface for Remote API Endpoints
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 * @since   0.2.0
 */

namespace NewsAPI\Traits;

trait RemoteEndpoints {
	/**
	 * Available remote endpoints.
	 *
	 * @var array
	 */
	protected $endpoints = [];

	/**
	 * Return valid endpoints on remote resource.
	 *
	 * @return array
	 */
	public function getEndpoints() {
		return $this->endpoints;
	}

	/**
	 * Return URL for target endpoint.
	 *
	 * @param string $endpointSlug Key value for target URL.
	 *
	 * @return array|null
	 */
	public function getEndpointUrl( string $endpointSlug ) {
		return isset( $this->endpoints[ $endpointSlug ] ) ? $this->endpoints[ $endpointSlug ] : null;
	}

	/**
	 * Setup available remote endpoints.
	 *
	 * @param array $endpoints List of remote endpoints
	 *
	 * @return void
	 */
	protected function setEndpoints( array $endpoints ): void {
		$this->endpoints = array_merge( $this->endpoints, $endpoints );
	}
}
