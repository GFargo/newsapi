<?php
/**
 * Base abstract class for API adapters.
 *
 *
 * @author  GFargo <griffen@alley.co>
 * @package NewsAPI
 */

namespace NewsAPI;

abstract class RemoteAPI {
	use Traits\RemoteEndpoints;
	use Traits\RemoteHeaders;

	abstract function query( string $endpoint, array $api_params = [], array $request_options = [] ): \Requests_Response;
}