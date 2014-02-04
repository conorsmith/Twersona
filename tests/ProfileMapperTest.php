<?php

namespace Twersona\Test;

use Twersona\ProfileMapper;

class ProfileMapperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockTwitter = $this->setUpMockTwitter();
        $this->mockCache = $this->setUpMockCache();

        $this->profileMapper = new ProfileMapper($this->mockTwitter, $this->mockCache);
    }

    private function setUpMockTwitter()
    {
        return $this->getMockBuilder('Twersona\TwitterConsumer')
            ->disableOriginalConstructor()
            ->setMethods(array('getProfileData'))
            ->getMock();
    }

    private function setUpMockCache()
    {
        return $this->getMockBuilder('Twersona\CacheInterface')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'isStale',
                'hasData',
                'fetch',
                'store',
            ))
            ->getMock();
    }

    /**
     * @test
     */
    public function readReturnsCachedData()
    {
        $expectedData = '{"data":"A Twitter profile..."}';

        $this->mockCache->expects($this->once())
            ->method('isStale')
            ->will($this->returnValue(false));

        $this->mockCache->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($expectedData));

        $actualData = $this->profileMapper->read();

        $this->assertEquals(
            $expectedData,
            $actualData,
            "ProfileMapper::read() did not return the expected cached data"
        );
    }

    /**
     * @test
     */
    public function readCallsTwitterAndCachesData()
    {
        $expectedData = '{"data":"A Twitter profile..."}';

        $this->mockCache->expects($this->once())
            ->method('isStale')
            ->will($this->returnValue(true));

        $this->mockTwitter->expects($this->once())
            ->method('getProfileData')
            ->will($this->returnValue($expectedData));

        $this->mockCache->expects($this->once())
            ->method('store')
            ->with($this->equalTo($expectedData));

        $actualData = $this->profileMapper->read();

        $this->assertEquals(
            $expectedData,
            $actualData,
            "ProfileMapper::read() did not retrieve and cache the expected data"
        );
    }
}
