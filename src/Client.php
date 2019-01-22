<?php
/**
 * NewsAPI Static Proxy Class Client
 *
 * @author  gfargo
 * @package NewsAPI
 */

namespace NewsAPI;

use NewsAPI\Interfaces\RemoteInterface;

final class Client {
	/**
	 * Controls what version of API is used.
	 *
	 * @var string
	 */
	public static $api_version = 'V2';

	/**
	 * Private Access Token used in API requests.
	 *
	 * @var string
	 */
	protected static $api_token;

	/**
	 * Register Personal API Access Token.
	 *
	 * @param string $api_token
	 */
	public static function set_access_token( string $api_token ) {
		self::$api_token = $api_token;
	}

	/**
	 * Returns Instance of API Adapter.
	 *
	 * @return RemoteInterface
	 * @throws \Exception
	 */
	public static function get_adapter(): RemoteInterface {
		// Bail if empty.
		if ( empty( self::$api_token ) ) {
			throw new \Exception( 'The API access token hasn\'t been set. Register your API access token via the `set_access_token` method. If you do not have an access token, one can be created at https://newsapi.org/account', 1 );
		}

		static $adapter = null;

		if ( null === $adapter ) {
			$adapter_version = __NAMESPACE__ . '\\' . self::$api_version . '\\Adapter';
			$adapter = new $adapter_version( self::$api_token );
		}

		return $adapter;
	}

	/**
	 * Query API using selected Adapter.
	 *
	 * @param string $endpoint
	 * @param array  $query_params
	 * @param array  $request_options
	 *
	 * @throws \Exception
	 *
	 * @return \Requests_Response Response object from from API request.
	 */
	public static function query( string $endpoint, array $query_params = [], array $request_options = [] ) {
		return self::get_adapter()->query( $endpoint, $query_params, $request_options );
	}
}