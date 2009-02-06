<?php
/**
 * @package Base
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * @package Base
 * @subpackage Tests
 */
class ezcBaseFeaturesWindowsTest extends ezcTestCase
{
    protected function setUp()
    {
        $uname = php_uname( 's' );
        if ( substr( $uname, 0, 7 ) != 'Windows' )
        {
            $this->markTestSkipped( 'Windows tests' );
        }
    }

    public function testSupportsLink()
    {
        $this->assertFalse( ezcBaseFeatures::supportsLink() );
    }

    public function testSupportsSymLink()
    {
        $this->assertFalse( ezcBaseFeatures::supportsSymLink() );
    }

    public function testSupportsUserId()
    {
        $this->assertFalse( ezcBaseFeatures::supportsUserId() );
    }

/*  // Need to find a way to make this test work, as setting global enviroment variables
    // is not working (putenv( "PATH=" ) doesn't unset $_ENV["PATH"])
    // One solution would be to use in the ezcBaseFeatures::getPath():
    // getenv( 'PATH' ) instead of $_ENV['PATH'] (but that won't work under IIS).
    public function testHasImageIdentifyNoPath()
    {
        $envPath = getenv( 'PATH' );
        putenv( "PATH=" );
        $this->assertEquals( false, ezcBaseFeatures::hasImageIdentify() );
        putenv( "PATH={$envPath}" );
    }
*/

    public function testHasImageConvert()
    {
        $this->assertTrue( ezcBaseFeatures::hasImageConvert() );
    }

    public function testGetImageConvertExecutable()
    {
        $this->assertNotNull( ezcBaseFeatures::getImageConvertExecutable() );
    }

    public function testGetImageIdentifyExecutable()
    {
        $this->assertNotNull( ezcBaseFeatures::getImageIdentifyExecutable() );
    }

    public function testHasImageIdentify()
    {
        $this->assertTrue( ezcBaseFeatures::hasImageIdentify() );
    }

    public function testHasExtensionSupport1()
    {
        $this->assertTrue( ezcBaseFeatures::hasExtensionSupport( 'standard' ) );
    }

    public function testHasExtensionSupportNotFound1()
    {
        $this->assertEquals( false, ezcBaseFeatures::hasExtensionSupport( 'non_existent_extension' ) );
        try
        {
            throw new ezcBaseExtensionNotFoundException( 'non_existent_extension', null, 'This is just a test.' );
        }
        catch ( ezcBaseExtensionNotFoundException $e )
        {
            $this->assertEquals( "The extension 'non_existent_extension' could not be found. This is just a test.",
                                 $e->getMessage() );
        }
    }

    public function testHasExtensionSupportNotFound2()
    {
        $this->assertEquals( false, ezcBaseFeatures::hasExtensionSupport( 'non_existent_extension' ) );
        try
        {
            throw new ezcBaseExtensionNotFoundException( 'non_existent_extension', '1.2', 'This is just a test.' );
        }
        catch ( ezcBaseExtensionNotFoundException $e )
        {
            $this->assertEquals( "The extension 'non_existent_extension' with version '1.2' could not be found. This is just a test.",
                                 $e->getMessage() );
        }
    }

    public function testHasFunction1()
    {
        $this->assertEquals( true, ezcBaseFeatures::hasFunction( 'function_exists' ) );
    }

    public function testHasFunction2()
    {
        $this->assertEquals( false, ezcBaseFeatures::hasFunction( 'non_existent_function_in_php' ) );
    }

    public function testHasExtensionSupport2()
    {
        $this->assertEquals( true, ezcBaseFeatures::hasExtensionSupport( 'date', '5.1.0' ) );
    }

    public function testClassExists()
    {
        $this->assertEquals( true, ezcBaseFeatures::classExists( 'Exception', false ) );
    }

    public function testClassExistsAutoload()
    {
        $this->assertEquals( true, ezcBaseFeatures::classExists( 'ezcBaseFeatures' ) );
    }

    public function testClassExistsNotFound()
    {
        $this->assertEquals( false, ezcBaseFeatures::classExists( 'ezcBaseNonExistingClass', false ) );
    }

    public function testClassExistsNotFoundAutoload()
    {
        $this->assertEquals( false, ezcBaseFeatures::classExists( 'ezcBaseNonExistingClass' ) );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
