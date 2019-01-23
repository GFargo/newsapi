<?php
/**
 * Remote API Interface Class
 *
 * @author  gfargo
 * @package NewsAPI
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
	 * @param $endpoint_slug
	 *
	 * @return array|null
	 */
	public function getEndpointUrl( $endpoint_slug ) {
		return isset( $this->endpoints[ $endpoint_slug ] ) ? $this->endpoints[ $endpoint_slug ] : null;
	}

	/**
	 * @param array $endpoints
	 */
	protected function setEndpoints( array $endpoints ): void {
		$this->endpoints = array_merge( $this->endpoints, $endpoints );
	}
}