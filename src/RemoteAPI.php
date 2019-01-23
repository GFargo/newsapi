<?php
/**
 * Base abstract class for API adapters.
 *
 *
 * @author  griffenfargo
 * @package php-test
 */

namespace NewsAPI;

abstract class RemoteAPI {
	use Traits\RemoteEndpoints;
	use Traits\RemoteHeaders;

	abstract function query( string $endpoint, array $api_params = [], array $request_options = [] );
}