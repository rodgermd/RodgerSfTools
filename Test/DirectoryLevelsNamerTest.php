<?php

namespace Rodgermd\SfToolsBundle\Test;

use Rodgermd\SfToolsBundle\Naming\DirectoryLevelsNamer;
use Vich\UploaderBundle\Mapping\PropertyMapping;

/**
 * Class DirectoryLevelsNamerTest
 */
class DirectoryLevelsNamerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test levels
     */
    public function testLevels()
    {
        $name = md5(uniqid());

        $namer = new DirectoryLevelsNamer();
        $namer->setLevels(2)->setLength(3);

        $mapping = $this->getPropertyMappingMock();
        $mapping->shouldReceive('getFileName')->andReturn($name);
        $result = $namer->directoryName(new \StdClass(), $mapping);

        $this->assertEquals($result, substr($name, 0, 3) . DIRECTORY_SEPARATOR . substr($name, 3, 3));

        $namer->setLevels(3);
        $result = $namer->directoryName(new \StdClass(), $mapping);
        $this->assertEquals($result, substr($name, 0, 3) . DIRECTORY_SEPARATOR . substr($name, 3, 3). DIRECTORY_SEPARATOR . substr($name, 6, 3));
    }

    /**
     * Test length
     */
    public function testLength()
    {
        $name = md5(uniqid());

        $namer = new DirectoryLevelsNamer();
        $namer->setLevels(2)->setLength(2);

        $mapping = $this->getPropertyMappingMock();
        $mapping->shouldReceive('getFileName')->andReturn($name);
        $result = $namer->directoryName(new \StdClass(), $mapping);

        $this->assertEquals($result, substr($name, 0, 2) . DIRECTORY_SEPARATOR . substr($name, 2, 2));

        $namer->setLength(3);
        $result = $namer->directoryName(new \StdClass(), $mapping);
        $this->assertEquals($result, substr($name, 0, 3) . DIRECTORY_SEPARATOR . substr($name, 3, 3));
    }

    /**
     * Tests short string
     */
    public function testShortString()
    {
        $name = 'abc';

        $namer = new DirectoryLevelsNamer();
        $namer->setLevels(2)->setLength(2);

        $mapping = $this->getPropertyMappingMock();
        $mapping->shouldReceive('getFileName')->andReturn($name);

        $result = $namer->directoryName(new \StdClass(), $mapping);
        $this->assertEquals($result, 'ab' . DIRECTORY_SEPARATOR . 'c');

        $namer->setLength(3);
        $result = $namer->directoryName(new \StdClass(), $mapping);
        $this->assertEquals($result, 'abc');

        $namer->setLength(2)->setLevels(4);
        $result = $namer->directoryName(new \StdClass(), $mapping);
        $this->assertEquals($result, 'ab' . DIRECTORY_SEPARATOR . 'c');
    }


    /**
     * Gets PropertyMapping mock
     *
     * @return \Mockery\MockInterface
     */
    protected function getPropertyMappingMock()
    {
        return \Mockery::mock(PropertyMapping::class);
    }
}