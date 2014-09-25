<?php
namespace JSONSchema\Tests\Structure\Property;

use JSONSchema\Structure\Item;
use JSONSchema\Structure\Property;

class AllPropsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $sUT = new Property();

        $id          = 'test';
        $type        = 'im';
        $key         = 'a';
        $name        = ',';
        $title       = 'super';
        $description = 'super !';
        $required    = false;
        $min         = 10;
        $max         = 11;

        $sUT->setId($id);
        $sUT->setType($type);
        $sUT->setKey($key);
        $sUT->setName($name);
        $sUT->setTitle($title);
        $sUT->setDescription($description);
        $sUT->setRequired($required);
        $sUT->setMin($min);
        $sUT->setMax($max);

        $this->assertEquals($id, $sUT->getId());
        $this->assertEquals($type, $sUT->getType());
        $this->assertEquals($key, $sUT->getKey());
        $this->assertEquals($name, $sUT->getName());
        $this->assertEquals($title, $sUT->getTitle());
        $this->assertEquals($description, $sUT->getDescription());
        $this->assertEquals($required, $sUT->getRequired());
        $this->assertEquals($min, $sUT->getMin());
        $this->assertEquals($max, $sUT->getMax());
    }

    public function testItemManipulation()
    {
        $sUT = new Property();

        $sUT->addItem('test', new Item());

        $this->assertSame(1, count($sUT->getItems()));

        $sUT->addItem('test', new Item());

        $this->assertSame(1, count($sUT->getItems()));

        $this->setExpectedException('JSONSchema\Structure\Exceptions\OverwriteKeyException');

        $sUT->addItem('test', new Item(), false);
    }

    public function testPropertiesManipulation()
    {
        $sUT = new Property();

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
        $sUT = new Property();

        $sUT->addProperty('test', new Property());
        $sUT->addItem('test', new Item());

        $this->assertInstanceOf('stdClass', $sUT->toObject());
    }
}
