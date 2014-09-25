<?php
namespace JSONSchema\Tests\Structure\Item;

use JSONSchema\Structure\Item;
use JSONSchema\Structure\Property;

class AllPropsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $sUT = new Item();

        $id                   = 'test';
        $type                 = 'im';
        $additionalProperties = false;
        $required             = 'test';

        $sUT->setId($id);
        $sUT->setType($type);
        $sUT->setAdditionalProperties($additionalProperties);
        $sUT->addRequired($required);

        $this->assertEquals($id, $sUT->getId());
        $this->assertEquals($type, $sUT->getType());
        $this->assertEquals($additionalProperties, $sUT->getAdditionalProperties());
        $this->assertEquals(array($required), $sUT->getRequired());
    }

    public function testPropertiesManipulation()
    {
        $sUT = new Item();

        $sUT->addProperty('test', new Property());

        $items = $sUT->getProperties();

        $this->assertSame(1, count($items));

        $sUT->addProperty('test', new Property());

        $this->assertSame(1, count($sUT->getProperties()));

        $this->setExpectedException('JSONSchema\Structure\Exceptions\OverwriteKeyException');

        $sUT->addProperty('test', new Property(), false);
    }

    public function testtoObject()
    {
        $sUT = new Item();

        $sUT->addProperty('test', new Property());
        $sUT->addRequired('test');

        $this->assertInstanceOf('stdClass', $sUT->toObject());
    }
}
