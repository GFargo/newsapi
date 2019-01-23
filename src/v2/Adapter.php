<?php
/**
 * NewsAPI PHP Wrapper
 *
 * @author  gfargo
 * @package NewsAPI
 */

namespace NewsAPI\V2;

class Adapter extends \NewsAPI\RemoteAPI {
	/**
	 * API key provided by NewsAPI.org
	 *
	 * @var string|null
	 */
	private $access_token;

	/**
	 * Initialize API Wrapper.
	 *
	 * @param string $access_token API Authorization key.
	 *
	 * @throws \Exception PHP Exceptions.
	 * @since  1.0.0
	 */
	public function __construct( string $access_token ) {
		$this->access_token = isset( $access_token ) ? $access_token : null;

		// Bail if empty.
		if ( empty( $this->access_token ) ) {
			throw new \Exception( 'API key is missing, please ensure valid key is provided.  If you do not have a key one can be created at https://newsapi.org/account', 1 );
		}

		$this->setHeaders( [
			'Access-Control-Allow-Origin'      => '*',
			'Access-Control-Allow-Methods'     => 'POST, GET',
			'Access-Control-Allow-Credentials' => 'true',
			'x-api-key'                        => $this->access_token,
		] );

		$this->setEndpoints( [
			'top'        => 'https://newsapi.org/v2/top-headlines',
			'everything' => 'https://newsapi.org/v2/everything',
			'sources'    => 'https://newsapi.org/v2/sources',
		] );

		return $this;
	}

	/**
	 * Construct the GET request URL.
	 *
	 * @param string $endpoint     Target endpoint.  Options are 'top', 'everything', and 'sources'
	 * @param array  $query_params API Request parameters.
	 *
	 * @throws \Exception
	 *
	 * @return string
	 */
	public function buildRequestUrl( string $endpoint, array $query_params ) {
		// Check we are working with valid endpoint.
		$valid_endpoints = array_keys( $this->getEndpoints() );

		if ( empty( $endpoint ) || ! in_array( $endpoint, $valid_endpoints ) ) {
			throw new \Exception( sprintf( 'Invalid endpoint. Valid options are "%s"', implode( '", "', $valid_endpoints ) ), 1 );
		}

		$http_query_url = http_build_query( $query_params );

		return (string) $this->getEndpointUrl( $endpoint ) . '?' . $http_query_url;
	}

	/**
	 * Query API for Results.
	 *
	 * @param string $endpoint        Slug of target API endpoint.  Options are 'top', 'everything', and 'sources'.
	 * @param array  $query_params    Query parameters passed to NewsAPI.org
	 * @param array  $request_options Options passed to Requests library to control CURL.
	 *
	 * @throws \Exception
	 *
	 * @return \Requests_Response Response object from from API request.
	 */
	public function query( string $endpoint, array $query_params = [], array $request_options = [] ): \Requests_Response {
		$request_url = $this->buildRequestUrl( $endpoint, $query_params );
		$response    = \Requests::get( $request_url, $this->getHeaders(), $request_options );

		return $response;
	}
}
