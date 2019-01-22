<?php
/**
 * API Test Class
 *
 * @author griffenfargo
 * @package NewsAPI
 */

namespace NewsAPI\Tests;

/**
 *  Corresponding Class to test YourClass class
 *
 *  For each class in your library, there should be a corresponding Unit-Test for it
 *  Unit-Tests should be as much as possible independent from other test going on.
 *
 * @author yourname
 */
class APITest extends \PHPUnit\Framework\TestCase {
	/**
	 * Instance of News API wrapper.
	 *
	 * @var \NewsAPI\API
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
		\NewsAPI\Client::set_access_token( $this->test_key );
	}

	/**
	 * Ensure library dependencies are available.
	 */
	public function testRequestsLib_ShouldExist_WhenDependenciesLoaded() {
		$this->assertTrue( class_exists( 'Requests' ) );
		$this->assertTrue( class_exists( 'Requests_Response' ) );
	}

	/**
	 * Test if we can initialize the API wrapper without issue.
	 */
	public function testSetup_ShouldBeInstanceOfAPIClass_WhenInitializedCorrectly() {
		$this->assertTrue( is_object( \NewsAPI\Client::get_adapter() ) );
		$this->assertTrue( \NewsAPI\Client::get_adapter() instanceof \NewsAPI\Interfaces\RemoteTrait );
	}

	/**
	 * Test that initializing API without valid key parameter throws exception.
	 * @TODO Refactor.
	 */
	public function Setup_ShouldThrowException_WhenNoAPIKeyPassed() {
		// Remove access token.
		\NewsAPI\Client::set_access_token( false );

		$this->expectException( \ArgumentCountError::class );
		$api = \NewsAPI\Client::get_adapter();
		unset( $api );

		// Reset access token.
		\NewsAPI\Client::set_access_token( $this->test_key );
	}

	/**
	 * Test headers array contain API key.
	 */
	public function testHeaders_ShouldIncludeAPIKey_WhenInitializedCorrectly() {
		$headers = \NewsAPI\Client::get_adapter()->headers;
		$this->assertArrayHasKey( 'x-api-key', $headers );
		$this->assertEquals( $this->test_key, $headers['x-api-key'] );
		unset( $headers );
	}

	/**
	 * Test if we can initialize the API wrapper without issue.
	 */
	public function testGetEndpoints_ShouldContainValidEndpoints_WhenCheckedAfterInit() {
		$endpoints = $this->news_api->getEndpoints();
		$this->assertArrayHasKey( 'top', $endpoints );
		$this->assertArrayHasKey( 'everything', $endpoints );
		$this->assertArrayHasKey( 'sources', $endpoints );
		unset( $endpoints );
	}

	/**
	 * Test that querying for invalid endpoint throws exception.
	 */
	public function testBuildRequestUrl_ShouldThrowException_WhenPassedInvalidEndpoint() {
		$this->expectException( \Exception::class );
		$response = $this->news_api->buildRequestUrl( 'bad_endpoint', [] );
		unset( $response );
	}

	/**
	 * Test if request URL is being properly constructed.
	 */
	public function testBuildRequestUrl_ShouldMatchExpected_WhenUsingSameParameters() {
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
