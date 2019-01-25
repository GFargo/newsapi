<?php
/**
 * Tests for RemoteAPI abstract class.
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 */

namespace NewsAPI\Tests;

//use NewsAPI\RemoteAPI;
use NewsAPI\RemoteAPI;
use PHPUnit\Framework\TestCase;

class RemoteAPITest extends TestCase {
	/**
	 * @var RemoteAPI
	 */
	private $test_class;

	/**
	 * @var array
	 */
	private $test_headers = [
		'header-a' => 'header-value',
		'header-b' => 'header-value-two',
	];

	/**
	 * Create an anon class to properly test
	 * the abstract RemoteAPI base class.
	 */
	public function setUp() {
		$this->test_class = new class extends RemoteAPI {
			protected $endpoints = [
				'endpoint-a' => 'http://endpoint.test/a/',
				'endpoint-b' => 'http://endpoint.test/b/',
			];

			public function query( string $endpoint, array $api_params = [], array $request_options = [] ): \Requests_Response {
				return new \Requests_Response();
			}
		};
	}

	public function testSetHeaders() {
		// Test headers can be initialized.
		$this->test_class->setHeaders( $this->test_headers );
		$this->assertEquals( $this->test_headers, $this->test_class->getHeaders() );

		// Test original header values can be overwritten.
		$this->test_class->setHeaders( [
			'header-b' => 'new-value',
		] );
		$new_headers = $this->test_class->getHeaders();
		$this->assertFalse( $new_headers['header-b'] === $this->test_headers['header-b'] );

		// Reset headers to initial state after test is complete.
		$this->test_class->setHeaders([]);
	}

	public function testGetHeaders_ShouldReturnEmptyArray() {
		$headers = $this->test_class->getHeaders();
		$this->assertEmpty( $headers );
		$this->assertTrue( is_array( $headers ) );
	}

	public function testGetEndpointUrl_ShouldReturnTargetEndpointUrl() {
		$this->assertEquals( 'http://endpoint.test/b/', $this->test_class->getEndpointUrl('endpoint-b') );
	}

	public function testGetEndpoints_ShouldReturnTestEndpoints() {
		$this->assertEquals( [
			'endpoint-a' => 'http://endpoint.test/a/',
			'endpoint-b' => 'http://endpoint.test/b/',
		], $this->test_class->getEndpoints() );
	}

	public function testQuery_ShouldReturnRequestResponseObject() {
		$response = $this->test_class->query( '', [], [] );
		$this->assertTrue( $response instanceof \Requests_Response );
	}
}
