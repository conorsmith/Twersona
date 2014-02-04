<?php

namespace Twersona\Test;

use Twersona\ProfileCache;

class ProfileCacheTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockFilesystem = $this->setUpMockFilesystem();
        $this->key = 'test_key';
        $this->maxAge = 86400;

        $this->profileCache = new ProfileCache($this->mockFilesystem, $this->key, $this->maxAge);
    }

    private function setUpMockFilesystem()
    {
        return $this->getMockBuilder('League\Flysystem\Filesystem')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getTimestamp',
                'has',
                'getSize',
                'read',
                'put',
            ))
            ->getMock();
    }

    private function setUpHasDataToReturnTrue()
    {
        $this->mockFilesystem->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $this->mockFilesystem->expects($this->once())
            ->method('getSize')
            ->will($this->returnValue(42));
    }

    /**
     * @test
     */
    public function isStaleReturnsTrueWhenHasDateReturnsFalse()
    {
        $this->mockFilesystem->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $this->assertTrue(
            $this->profileCache->isStale(),
            "ProfileCache::isStale() did not return true as expected for a missing file"
        );
    }

    /**
     * @test
     */
    public function isStaleReturnsTrueWhenFileIsVeryOld()
    {
        $this->setUpHasDataToReturnTrue();

        $farPast = new \DateTime('20-04-1983');
        $farPastTimestamp = $farPast->format('U');

        $this->mockFilesystem->expects($this->once())
            ->method('getTimestamp')
            ->will($this->returnValue($farPastTimestamp));

        $this->assertTrue(
            $this->profileCache->isStale(),
            "ProfileCache::isStale() did not return true as expected for a very old file"
        );
    }

    /**
     * @test
     */
    public function isStaleReturnsFalseWhenFileIsNewish()
    {
        $this->setUpHasDataToReturnTrue();

        $timestampToCheck = time();
        $newishTimestamp = $timestampToCheck - 3600;

        $this->mockFilesystem->expects($this->once())
            ->method('getTimestamp')
            ->will($this->returnValue($newishTimestamp));

        $this->assertFalse(
            $this->profileCache->isStale($timestampToCheck),
            "ProfileCache::isStale() did not return false as expected for a newish file"
        );
    }

    /**
     * @test
     */
    public function isStaleReturnsFalseWhenFileIsAtMaxAge()
    {
        $this->setUpHasDataToReturnTrue();

        $timestampToCheck = time();
        $maxAgeTimestamp = $timestampToCheck - $this->maxAge;

        $this->mockFilesystem->expects($this->once())
            ->method('getTimestamp')
            ->will($this->returnValue($maxAgeTimestamp));

        $this->assertFalse(
            $this->profileCache->isStale($timestampToCheck),
            "ProfileCache::isStale() did not return false as expected for a file at its max age"
        );
    }

    /**
     * @test
     */
    public function isStaleReturnsTrueWhenFileIsOneSecondPastMaxAge()
    {
        $this->setUpHasDataToReturnTrue();

        $timestampToCheck = time();
        $overMaxAgeTimestamp = $timestampToCheck - $this->maxAge - 1;

        $this->mockFilesystem->expects($this->once())
            ->method('getTimestamp')
            ->will($this->returnValue($overMaxAgeTimestamp));

        $this->assertTrue(
            $this->profileCache->isStale($timestampToCheck),
            "ProfileCache::isStale() did not return true as expected for a file just past its max age"
        );
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
            "ProfileCache::hasData() did not return false as expected for a missing file"
        );
    }

    /**
     * @test
     */
    public function hasDataReturnsFalseWhenFileSizeIsZero()
    {
        $this->mockFilesystem->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $this->mockFilesystem->expects($this->once())
            ->method('getSize')
            ->will($this->returnValue(0));

        $this->assertFalse(
            $this->profileCache->hasData(),
            "ProfileCache::hasData() did not return false as expected for an empty file"
        );
    }
}
