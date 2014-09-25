<?php
namespace JSONSchema\Tests\Mappers\PropertyTypeMapper;

use JSONSchema\Mappers\PropertyTypeMapper;

class MapTest extends \PHPUnit_Framework_TestCase
{
    public function testType()
    {
        $this->assertEquals(PropertyTypeMapper::STRING_TYPE, PropertyTypeMapper::map('im string !'));
        $this->assertEquals(PropertyTypeMapper::NUMBER_TYPE, PropertyTypeMapper::map(10.2));
        $this->assertEquals(PropertyTypeMapper::INTEGER_TYPE, PropertyTypeMapper::map(10));
        $this->assertEquals(PropertyTypeMapper::INTEGER_TYPE, PropertyTypeMapper::map(0));
        $this->assertEquals(PropertyTypeMapper::INTEGER_TYPE, PropertyTypeMapper::map(1));
        $this->assertEquals(PropertyTypeMapper::NULL_TYPE, PropertyTypeMapper::map(null));
        $this->assertEquals(PropertyTypeMapper::BOOLEAN_TYPE, PropertyTypeMapper::map(true));
        $this->assertEquals(PropertyTypeMapper::BOOLEAN_TYPE, PropertyTypeMapper::map(false));
        $this->assertEquals(PropertyTypeMapper::ARRAY_TYPE, PropertyTypeMapper::map(array()));
        $this->assertEquals(PropertyTypeMapper::OBJECT_TYPE, PropertyTypeMapper::map(new \stdClass()));
    }
}
