<?php
/**
 * Test Client Static Proxy Class
 *
 * @author  gfargo
 * @package NewsAPI
 */

namespace NewsAPI\Tests;

use NewsAPI\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

	private $test_access_token = 'test_token';

	/**
	 * Test functionality for setting and validating API access token.
	 */
	public function testSetAccessToken() {
		Client::setAccessToken( '' );
		$this->assertFalse( Client::isAccessTokenValid() );

		Client::setAccessToken( $this->test_access_token );
		$this->assertTrue( Client::isAccessTokenValid() );
	}

	/**
	 * Test that getting the API adapter without valid key parameter throws exception.
	 */
	public function testGetAdapter_ShouldThrowException_WhenInvalidAccessTokenUsed() {
		Client::setAccessToken( '' );
		$this->expectException( \Exception::class );
		$adapter = Client::getAdapter();
		unset( $adapter );
	}

	public function testGetAdapter_ShouldExtendRemoteAPI() {
		Client::setAccessToken( $this->test_access_token );
		$adapter = Client::getAdapter();
		$this->assertTrue( is_object( $adapter ) );
		$this->assertTrue( $adapter instanceof \NewsAPI\RemoteAPI );
		unset( $adapter );
	}

	public function testQuery() {

	}
}
