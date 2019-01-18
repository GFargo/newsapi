<?php
/**
 * NewsAPI Test Class
 *
 * @author griffenfargo
 * @package NewsAPI
 */

namespace GFargo\NewsAPI\Tests;

use GFargo\NewsAPI\API;

/**
 *  Corresponding Class to test YourClass class
 *
 *  For each class in your library, there should be a corresponding Unit-Test for it
 *  Unit-Tests should be as much as possible independent from other test going on.
 *
 * @author yourname
 */
class NewsAPITest extends \PHPUnit\Framework\TestCase {
	/**
	 * Instance of News API wrapper.
	 *
	 * @var API
	 */
	protected $news_api;

	/**
	 * Test API Key
	 * @var string
	 */
	protected $test_key = 'test_api_key';

	/**
	 * Setup class for unit testing.
	 *
	 * @throws \Exception Throws exception when API is initialized without api key.
	 */
	protected function setUp() {
		parent::setUp();
		$this->news_api = new API( $this->test_key );
	}

	/**
	 * Test that initializing API without valid key parameter throws exception.
	 */
	public function testForExceptionWhenInitializingWithoutAPIKey() {
		$this->expectException( \ArgumentCountError::class );
		$api = new API();
		unset( $api );
	}

	/**
	 * Test if we can initialize the API wrapper without issue.
	 */
	public function testForSyntaxError() {
		$this->assertTrue( is_object( $this->news_api ) );
		$this->assertTrue( $this->news_api instanceof API );
	}

	/**
	 * Test headers array contain API key.
	 */
	public function testForAPIKeyInHeaders() {
		$headers = $this->news_api->headers;
		$this->assertArrayHasKey( 'x-api-key', $headers );
		$this->assertEquals( $this->test_key, $headers['x-api-key'] );
		unset( $headers );
	}

	/**
	 * Test if we can initialize the API wrapper without issue.
	 */
	public function testForValidEndpoints() {
		$endpoints = $this->news_api->getEndpoints();
		$this->assertArrayHasKey( 'top', $endpoints );
		$this->assertArrayHasKey( 'everything', $endpoints );
		$this->assertArrayHasKey( 'sources', $endpoints );
		unset( $endpoints );
	}

	/**
	 * Test that querying for invalid endpoint throws exception.
	 */
	public function testInValidEndpoint() {
		$this->expectException( \Exception::class );
		$response = $this->news_api->buildRequestUrl( 'bad_endpoint', [] );
		unset( $response );
	}

	/**
	 * Ensure request library provided by composer is available.
	 */
	public function testRequestsLibrary() {
		$this->assertTrue( class_exists( 'Requests' ) );
		$this->assertTrue( class_exists( 'Requests_Response' ) );
	}

	/**
	 * Test if request URL is being properly constructed.
	 */
	public function testQueryUrlGeneration() {
		// Top business headlines from Germany.
		$expected_url  = 'https://newsapi.org/v2/top-headlines?country=de&category=business';
		$generated_url = $this->news_api->buildRequestUrl(
			'top',
			[
				'country'  => 'de',
				'category' => 'business',
			]
		);
		$this->assertEquals( $expected_url, $generated_url );

		// Top headlines from BBC News.
		$expected_url  = 'https://newsapi.org/v2/top-headlines?sources=bbc-news';
		$generated_url = $this->news_api->buildRequestUrl(
			'top',
			[
				'sources' => 'bbc-news',
			]
		);
		$this->assertEquals( $expected_url, $generated_url );

		// All articles mentioning Apple from yesterday, sorted by popular publishers first.
		$expected_url  = 'https://newsapi.org/v2/everything?q=apple&from=2019-01-17&to=2019-01-17&sortBy=popularity';
		$generated_url = $this->news_api->buildRequestUrl(
			'everything',
			[
				'q'      => 'apple',
				'from'   => '2019-01-17',
				'to'     => '2019-01-17',
				'sortBy' => 'popularity',
			]
		);
		$this->assertEquals( $expected_url, $generated_url );

		// All named sources with English news in the US.
		$expected_url  = 'https://newsapi.org/v2/sources?language=en&country=us';
		$generated_url = $this->news_api->buildRequestUrl(
			'sources',
			[
				'language' => 'en',
				'country'  => 'us',
			]
		);
		$this->assertEquals( $expected_url, $generated_url );
		unset( $expected_url, $generated_url );
	}
}
