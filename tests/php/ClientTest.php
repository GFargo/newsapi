<?php
/**
 * Test Client Static Proxy Class
 *
 * @author  GFargo <griffen@alley.co>
 * @package NewsAPI
 */

namespace NewsAPI\Tests;

use NewsAPI\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {
	/**
	 * Test API access token.
	 * @var string
	 */
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

	/**
	 * Test that Adapter class properly extends RemoteAPI abstract class.
	 * @throws \Exception
	 */
	public function testGetAdapter_ShouldExtendRemoteAPI() {
		Client::setAccessToken( $this->test_access_token );
		$adapter = Client::getAdapter();
		$this->assertTrue( is_object( $adapter ) );
		$this->assertTrue( $adapter instanceof \NewsAPI\RemoteAPI );
		unset( $adapter );
	}

	/**
	 * Test exception is thrown when using invalid API endpoint.
	 * @throws \Exception
	 */
	public function testQuery_ShouldThrowException_WhenUsingInvalidEndpoint() {
		Client::setAccessToken( $this->test_access_token );
		$this->expectException( \Exception::class );
		Client::query('invalid', []);
	}

	/**
	 * Pass mock transport to Requests library to test query response.
	 * @throws \Exception
	 */
	public function testQuery_ShouldReturnRequestResponseObject() {
		$transport = new \NewsAPIMockTransport();
		$transport->code = 302;

		Client::setAccessToken( $this->test_access_token );
		$response = Client::query('top', [], [
			'transport' => $transport
		]);

		$this->assertEquals(302, $response->status_code);
		$this->assertEquals(0, $response->redirects);
		$this->assertTrue( is_object( $response ) );
		$this->assertTrue( $response instanceof \Requests_Response );
	}
}
