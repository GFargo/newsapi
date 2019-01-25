<?php
/**
 * NewsAPI Static Proxy Class Client
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 * @since   0.2.0*
 */

namespace NewsAPI;

final class Client {
	/**
	 * Controls what version of API is used.
	 *
	 * @var string
	 */
	public static $version = 'V2';

	/**
	 * API access token used in requests.
	 *
	 * @var string
	 */
	protected static $privateKey;

	/**
	 * Register API access token.
	 *
	 * @param string $apiKey Personal API access key
	 *
	 * @return void
	 */
	public static function setAccessToken( string $apiKey ) {
		self::$privateKey = $apiKey;
	}

	/**
	 * Check if API access token is valid.
	 *
	 * @return bool
	 */
	public static function isAccessTokenValid(): bool {
		return ! empty( self::$privateKey ) && is_string( self::$privateKey );
	}

	/**
	 * Returns Instance of API Adapter.
	 *
	 * @return RemoteAPI
	 *
	 * @throws \Exception
	 */
	public static function getAdapter(): RemoteAPI {
		// Bail if empty.
		if ( ! self::isAccessTokenValid() ) {
			throw new \Exception( 'The API access token hasn\'t been set properly. Register your API access token via the `set_access_token` method. If you do not have an access token, one can be created at https://newsapi.org/account', 1 );
		}

		static $adapterObj = null;

		if ( null === $adapterObj ) {
			$adapter    = __NAMESPACE__ . '\\' . self::$version . '\\Adapter';
			$adapterObj = new $adapter( self::$privateKey );
		}

		return $adapterObj;
	}

	/**
	 * Query API using selected Adapter.
	 *
	 * @param string $endpoint       Slug of target API endpoint.  Options are 'top', 'everything', and 'sources'.
	 * @param array  $queryParams    Query parameters passed to NewsAPI.org
	 * @param array  $requestOptions Args passed to Requests library to control CURL.
	 *
	 * @throws \Exception
	 *
	 * @return \Requests_Response Response object from from API request.
	 */
	public static function query( string $endpoint, array $queryParams = [], array $requestOptions = [] ): \Requests_Response {
		return self::getAdapter()->query( $endpoint, $queryParams, $requestOptions );
	}
}
