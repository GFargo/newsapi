<?php
/**
 * Test for library dependencies.
 *
 * @package NewsAPI
 * @author  GFargo <griffen@alley.co>
 */

namespace NewsAPI\Tests;

use PHPUnit\Framework\TestCase;

class DependencyTest extends TestCase {
	/**
	 * Ensure library dependencies are available.
	 */
	public function testRequestsLib_ShouldExist_WhenDependenciesLoaded() {
		$this->assertTrue( class_exists( 'Requests' ) );
		$this->assertTrue( class_exists( 'Requests_Response' ) );
	}
}
