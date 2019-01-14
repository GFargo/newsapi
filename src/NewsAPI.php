<?php
/**
 * NewsAPI PHP Wrapper
 *
 * @author gfargo
 * @package NewsAPI
 */

namespace GFargo\NewsAPI;

class API {
	/**
	 * API key from NewsAPI.org.
	 *
	 * @var String
	 */
	protected $apiKey;

	/**
	 * Available endpoints.
	 *
	 * @var array
	 */
	protected $endpoints = [
		'top'        => 'https://newsapi.org/v2/top-headlines',
		'everything' => 'https://newsapi.org/v2/everything',
		'sources'    => 'https://newsapi.org/v2/sources',
	];

	/**
	 * HTTP Headers used with API requests.
	 *
	 * @var array
	 */
	public $headers = [
		'Access-Control-Allow-Origin'      => '*',
		'Access-Control-Allow-Methods'     => 'POST, GET',
		'Access-Control-Allow-Credentials' => 'true',
	];

	/**
	 * Constructor.
	 *
	 * @param string $api_key API Authorization key.
	 *
	 * @throws \Exception PHP Exceptions.
	 * @since  1.0.0
	 */
	public function __construct( string $api_key ) {
		$this->apiKey = isset( $api_key ) ? $api_key : null;

		// Bail if empty.
		if ( empty( $this->apiKey ) ) {
			throw new \Exception( 'API key is missing, please ensure valid key is provided.  If you do not have a key one can be created at https://newsapi.org/account', 1 );
		}

		$this->headers['x-api-key'] = $this->apiKey;
	}

	/**
	 * Return valid API endpoints.
	 *
	 * @return array
	 */
	public function getEndpoints(): array {
		return $this->endpoints;
	}

	/**
	 * @param string $endpoint
	 * @param array  $query_params
	 *
	 * @throws \Exception
	 *
	 * @return string
	 */
	public function buildRequestUrl( string $endpoint, array $query_params ) {
		// Check we are working with valid endpoint.
		$valid_endpoints = array_keys( $this->endpoints );
		if ( empty( $endpoint ) || ! in_array( $endpoint, $valid_endpoints ) ) {
			throw new \Exception( sprintf( 'Invalid endpoint. Possible options are %s', implode( ', ', $valid_endpoints ) ), 1 );
		}

		$http_query_url = http_build_query( $query_params );

		return (string) $this->endpoints[ $endpoint ] . '?' . $http_query_url;
	}

	/**
	 * Query API for Results.
	 *
	 * @param string $endpoint
	 * @param array  $api_params
	 * @param array  $request_options
	 *
	 * @throws \Exception
	 *
	 * @return \Requests_Response Response object from from API request.
	 */
	public function query( string $endpoint, array $api_params = [], array $request_options = [] ) {
		$request_url = $this->buildRequestUrl( $endpoint, $api_params );
		$response    = \Requests::get( $request_url, $this->headers, $request_options );

		return $response;
	}

}
