<?php
/**
 * Base abstract class for API adapters.
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 */

namespace NewsAPI;

abstract class RemoteAPI {
	use Traits\RemoteEndpoints;
	use Traits\RemoteHeaders;

	/**
	 * Query Remote
	 *
	 * @param string $endpoint       Slug of target remote endpoint
	 * @param array  $apiParams      Query parameters passed to remote API
	 * @param array  $requestOptions Options controlling how request is made to remote
	 *
	 * @return \Requests_Response
	 */
	abstract public function query( string $endpoint, array $apiParams = [], array $requestOptions = [] ): \Requests_Response;
}
