<?php

namespace Twersona\Test;

use Twersona\ProfileCache;

class ProfileCacheTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockFilesystem = $this->setUpMockFilesystem();
        $this->key = 'test_key';

        $this->profileCache = new ProfileCache($this->mockFilesystem, $this->key);
    }

    private function setUpMockFilesystem()
    {
        return $this->getMockBuilder('League\Flysystem\Filesystem')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'has',
                'getSize',
                'read',
                'put',
            ))
            ->getMock();
    }

    /**
     * @test
     */
    public function hasDataReturnsFalseWhenNoValueExistsForKey()
    {
        $this->mockFilesystem->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $this->assertFalse(
            $this->profileCache->hasData(),
            "ProfileCache::hasData() did not return false as expected"
        );
    }
}
