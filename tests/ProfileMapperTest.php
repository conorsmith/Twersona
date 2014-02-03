<?php

namespace Twersona\Test;

use Twersona\ProfileMapper;

class ProfileMapperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockTwitter = $this->setUpMockTwitter();
        $this->mockStorer = $this->setUpMockStorer();

        $this->profileMapper = new ProfileMapper($this->mockTwitter, $this->mockStorer);
    }

    private function setUpMockTwitter()
    {
        return $this->getMockBuilder('Twersona\TwitterAPI')
            ->disableOriginalConstructor()
            ->setMethods(array('getProfileData'))
            ->getMock();
    }

    private function setUpMockStorer()
    {
        return $this->getMockBuilder('Twersona\StorerInterface')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'hasCachedData',
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
        $profileMapper = new ProfileMapper('Invalid param type', $this->mockStorer);
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

        $profileMapper = new ProfileMapper($connectionSettings, $this->mockStorer);
        */
    }

    /**
     * @test
     */
    public function constructorAcceptsMissingSecondParam()
    {
        $profileMapper = new ProfileMapper($this->mockTwitter);
    }

    /**
     * @test
     */
    public function readReturnsCachedData()
    {
        $expectedData = '{"data":"A Twitter profile..."}';

        $this->mockStorer->expects($this->once())
            ->method('hasCachedData')
            ->will($this->returnValue(true));

        $this->mockStorer->expects($this->once())
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

        $this->mockStorer->expects($this->once())
            ->method('hasCachedData')
            ->will($this->returnValue(false));

        $this->mockTwitter->expects($this->once())
            ->method('getProfileData')
            ->will($this->returnValue($expectedData));

        $this->mockStorer->expects($this->once())
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
