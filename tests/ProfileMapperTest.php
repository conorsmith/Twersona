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
        return $this->getMockBuilder('Twersona\TwitterAPI')
            ->disableOriginalConstructor()
            ->setMethods(array('getProfileData'))
            ->getMock();
    }

    private function setUpMockCache()
    {
        return $this->getMockBuilder('Twersona\CacheInterface')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'hasData',
                'fetch',
                'store',
            ))
            ->getMock();
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function constructorThrowsExceptionForInvalidFirstParam()
    {
        $profileMapper = new ProfileMapper('Invalid param type', $this->mockCache);
    }

    /**
     * @test
     */
    public function constructorAcceptsArrayAsFirstParam()
    {
        /*
        TODO - I'm not sure how to test this yet, the literla class name is
               causing dependency issues. Perhaps a DIC is the solution?

        $connectionSettings = array(
            'some_key' => 'some_value',
        );

        $profileMapper = new ProfileMapper($connectionSettings, $this->mockCache);
        */
    }

    /**
     * @test
     */
    public function readReturnsCachedData()
    {
        $expectedData = '{"data":"A Twitter profile..."}';

        $this->mockCache->expects($this->once())
            ->method('hasData')
            ->will($this->returnValue(true));

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
            ->method('hasData')
            ->will($this->returnValue(false));

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
