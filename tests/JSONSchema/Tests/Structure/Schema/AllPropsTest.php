<?php
namespace JSONSchema\Tests\Structure\Schema;

use JSONSchema\Structure\Schema;
use JSONSchema\Structure\Item;
use JSONSchema\Structure\Property;

class AllPropsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $sUT = new Schema();

        $description  = 'im';
        $dollarSchema = 'a';
        $id           = 'test';
        $required     = 'very';
        $title        = 'super';
        $type         = 'efficient';

        $sUT->setDescription($description);
        $sUT->setDollarSchema($dollarSchema);
        $sUT->setId($id);
        $sUT->addRequired($required);
        $sUT->setTitle($title);
        $sUT->setType($type);

        $this->assertEquals($description, $sUT->getDescription());
        $this->assertEquals($dollarSchema, $sUT->getDollarSchema());
        $this->assertEquals($id, $sUT->getId());
        $this->assertEquals(array($required), $sUT->getRequired());
        $this->assertEquals($title, $sUT->getTitle());
        $this->assertEquals($type, $sUT->getType());
    }

    public function testItemManipulation()
    {
        $sUT = new Schema();

        $sUT->addItem('test', new Item());

        $this->assertSame(1, count($sUT->getItems()));

        $sUT->addItem('test', new Item());

        $this->assertSame(1, count($sUT->getItems()));

        $sUT->removeItem('test');

        $this->assertSame(0, count($sUT->getItems()));
        $this->assertSame(0, count($sUT->getRequired()));

        $sUT->addItem('test', new Item(), true);

        $this->assertSame(1, count($sUT->getItems()));
        $this->assertSame(1, count($sUT->getRequired()));

        $this->setExpectedException('JSONSchema\Structure\Exceptions\OverwriteKeyException');

        $sUT->addItem('test', new Item(), false, false);
    }

    public function testPropertiesManipulation()
    {
        $sUT = new Schema();

        $sUT->addProperty('test', new Property());

        $items = $sUT->getProperties();

        $this->assertSame(1, count($items));

        $sUT->addProperty('test', new Property(), true);

        $this->assertSame(1, count($sUT->getProperties()));
        $this->assertSame(1, count($sUT->getRequired()));

        $sUT->removeProperty('test');

        $this->assertSame(0, count($sUT->getProperties()));
        $this->assertSame(0, count($sUT->getRequired()));

        $sUT->addProperty('test', new Property(), true);

        $this->assertSame(1, count($sUT->getProperties()));
        $this->assertSame(1, count($sUT->getRequired()));

        $this->setExpectedException('JSONSchema\Structure\Exceptions\OverwriteKeyException');

        $sUT->addProperty('test', new Property(), false, false);
    }

    public function testToString()
    {
        $sUT = new Schema();

        $sUT->addProperty('test', new Property());
        $sUT->addItem('test', new Item());

        $this->assertInternalType('string', $sUT->toString());
    }

    public function testToArray()
    {
        $sUT = new Schema();

        $sUT->addProperty('test', new Property());
        $sUT->addItem('test', new Item());

        $this->assertInternalType('array', $sUT->toArray());
    }
}
