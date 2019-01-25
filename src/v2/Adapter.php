<?php
/**
 * NewsAPI v2 Adapter Class
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 * @since   0.2.0
 */

namespace NewsAPI\V2;

class Adapter extends \NewsAPI\RemoteAPI {
	/**
	 * API key provided by NewsAPI.org
	 *
	 * @var string|null
	 */
	private $_privateKey;

	/**
	 * Initialize API Wrapper.
	 *
	 * @param string $apiKey API Authorization key.
	 *
	 * @throws \Exception PHP Exceptions.
	 * @since  1.0.0
	 */
	public function __construct( string $apiKey ) {
		$this->_privateKey = isset( $apiKey ) ? $apiKey : null;

		// Bail if empty.
		if ( empty( $this->_privateKey ) ) {
			throw new \Exception( 'API key is missing, please ensure valid key is provided.  If you do not have a key one can be created at https://newsapi.org/account', 1 );
		}

		$this->setHeaders( [
			'Access-Control-Allow-Origin'      => '*',
			'Access-Control-Allow-Methods'     => 'POST, GET',
			'Access-Control-Allow-Credentials' => 'true',
			'x-api-key'                        => $this->_privateKey,
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
	 * @param string $endpoint    Target endpoint.  Options are 'top', 'everything', and 'sources'
	 * @param array  $queryParams API Request parameters.
	 *
	 * @throws \Exception
	 *
	 * @return string
	 */
	public function buildRequestUrl( string $endpoint, array $queryParams ) {
		// Check we are working with valid endpoint.
		$validEndpoints = array_keys( $this->getEndpoints() );

		if ( empty( $endpoint ) || ! in_array( $endpoint, $validEndpoints ) ) {
			throw new \Exception( sprintf( 'Invalid endpoint. Valid options are "%s"', implode( '", "', $validEndpoints ) ), 1 );
		}

		$httpQueryUrl = http_build_query( $queryParams );

		return (string) $this->getEndpointUrl( $endpoint ) . '?' . $httpQueryUrl;
	}

	/**
	 * Query V2 API Endpoints for Results.
	 *
	 * @param string $endpoint       Slug of target API endpoint.  Options are 'top', 'everything', and 'sources'.
	 * @param array  $queryParams    Query parameters passed to NewsAPI.org
	 * @param array  $requestOptions Options controlling how request is made to remote
	 *
	 * @throws \Exception
	 *
	 * @return \Requests_Response Response object from from API request.
	 */
	public function query( string $endpoint, array $queryParams = [], array $requestOptions = [] ): \Requests_Response {
		$requestUrl = $this->buildRequestUrl( $endpoint, $queryParams );
		$response   = \Requests::get( $requestUrl, $this->getHeaders(), $requestOptions );

		return $response;
	}
}
