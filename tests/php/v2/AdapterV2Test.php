<?php
/**
 * Test V2 Adapter class.
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 */

namespace NewsAPI\Tests;

use NewsAPI\V2\Adapter;
use PHPUnit\Framework\TestCase;

class AdapterV2Test extends TestCase {
	/**
	 * Instance of v2 Adapter class
	 *
	 * @var Adapter
	 */
	private $adapter;

	private $test_access_token = 'test_token';

	private $expected_endpoints = [
		'top'        => 'https://newsapi.org/v2/top-headlines',
		'everything' => 'https://newsapi.org/v2/everything',
		'sources'    => 'https://newsapi.org/v2/sources',
	];

	private $expected_headers = [
		'Access-Control-Allow-Origin'      => '*',
		'Access-Control-Allow-Methods'     => 'POST, GET',
		'Access-Control-Allow-Credentials' => 'true',
	];

	/**
	 * Initialize and store instance of V2 adapter with phony access token for testing.
	 *
	 * @throws \Exception
	 */
	protected function setUp() {
		$this->adapter = new Adapter( $this->test_access_token );
	}

	/**
	 * Test if we can initialize the API wrapper without issue.
	 */
	public function testAdapterClass_ShouldExtendRemoteAPIBaseClass() {
		$this->assertTrue( is_object( $this->adapter ) );
		$this->assertTrue( $this->adapter instanceof \NewsAPI\RemoteAPI );
	}

	/**
	 * Test that initializing Adapter without valid key parameter throws exception.
	 */
	public function testAdapterClass_ShouldThrowException_WhenNoAPIKeyPassed() {
		$this->expectException( \Exception::class );
		$exception_adapter = new Adapter(false);
		unset( $exception_adapter );
	}

	/**
	 * Test if we can initialize the API wrapper without issue.
	 */
	public function testGetEndpoints_ShouldContainValidEndpoints() {
		$endpoints = $this->adapter->getEndpoints();

		$this->assertArrayHasKey( 'top', $endpoints );
		$this->assertArrayHasKey( 'everything', $endpoints );
		$this->assertArrayHasKey( 'sources', $endpoints );

		unset( $endpoints );
	}

	public function testGetEndpointUrl_ShouldReturnTopHeadlines() {
		$this->assertEquals( 'https://newsapi.org/v2/top-headlines', $this->adapter->getEndpointUrl('top') );
		$this->assertEquals( 'https://newsapi.org/v2/everything', $this->adapter->getEndpointUrl('everything') );
		$this->assertEquals( 'https://newsapi.org/v2/sources', $this->adapter->getEndpointUrl('sources') );
	}

	public function testSetHeaders() {
		$this->adapter->setHeaders([
			'test-header' => true
		]);

		$this->assertArrayHasKey( 'test-header', $this->adapter->getHeaders() );
	}

	public function testGetHeaders_ShouldContainExpectedHeaderKeys() {
		foreach ( array_keys( $this->expected_headers ) as $key ) {
			$this->assertArrayHasKey( $key, $this->adapter->getHeaders() );
		}
	}

	/**
	 * Test headers array contain test access token.
	 */
	public function testGetHeaders_ShouldIncludeAPIKey_WhenInitializedCorrectly() {
		$headers = $this->adapter->getHeaders();
		$this->assertArrayHasKey( 'x-api-key', $headers );
		$this->assertEquals( $this->test_access_token, $headers['x-api-key'] );
		unset( $headers );
	}

	/**
	 * Test that querying for invalid endpoint throws exception.
	 */
	public function testBuildRequestUrl_ShouldThrowException_WhenPassedInvalidEndpoint() {
		$this->expectException( \Exception::class );
		$response = $this->adapter->buildRequestUrl( 'bad_endpoint', [] );
		unset( $response );
	}

	/**
	 * Test if request URL is being properly constructed.
	 */
	public function testBuildRequestUrl_ShouldMatchExpected_WhenUsingSameParameters() {
		// Top business headlines from Germany.
		$expected  = 'https://newsapi.org/v2/top-headlines?country=de&category=business';
		$generated = $this->adapter->buildRequestUrl(
			'top',
			[
				'country'  => 'de',
				'category' => 'business',
			]
		);
		$this->assertEquals( $expected, $generated );

		// Top headlines from BBC News.
		$expected  = 'https://newsapi.org/v2/top-headlines?sources=bbc-news';
		$generated = $this->adapter->buildRequestUrl(
			'top',
			[
				'sources' => 'bbc-news',
			]
		);
		$this->assertEquals( $expected, $generated );

		// All articles mentioning Apple from yesterday, sorted by popular publishers first.
		$expected  = 'https://newsapi.org/v2/everything?q=apple&from=2019-01-17&to=2019-01-17&sortBy=popularity';
		$generated = $this->adapter->buildRequestUrl(
			'everything',
			[
				'q'      => 'apple',
				'from'   => '2019-01-17',
				'to'     => '2019-01-17',
				'sortBy' => 'popularity',
			]
		);
		$this->assertEquals( $expected, $generated );

		// All named sources with English news in the US.
		$expected  = 'https://newsapi.org/v2/sources?language=en&country=us';
		$generated = $this->adapter->buildRequestUrl(
			'sources',
			[
				'language' => 'en',
				'country'  => 'us',
			]
		);
		$this->assertEquals( $expected, $generated );
		unset( $expected, $generated );
	}

	public function testQuery_ShouldReturnRequestResponseObject() {
		$transport = new \NewsAPIMockTransport();
		$transport->code = 200;

		$response = $this->adapter->query('everything', [], [
			'transport' => $transport
		]);

		$this->assertEquals(200, $response->status_code);
		$this->assertEquals(0, $response->redirects);
		$this->assertTrue( is_object( $response ) );
		$this->assertTrue( $response instanceof \Requests_Response );
	}
}
