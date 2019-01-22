<?php
/**
 * @TODO    : File Desc.
 *
 * @author  griffenfargo
 * @package php-test
 */

namespace NewsAPI\Interfaces;

interface RemoteInterface {

	public function buildRequestUrl( string $endpoint, array $query_params );

	public function query( string $endpoint, array $api_params = [], array $request_options = [] );
}