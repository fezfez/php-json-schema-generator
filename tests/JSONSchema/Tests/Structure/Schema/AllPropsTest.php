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
        $mediaType    = ',';
        $required     = 'very';
        $title        = 'super';
        $type         = 'efficient';

        $sUT->setDescription($description);
        $sUT->setDollarSchema($dollarSchema);
        $sUT->setId($id);
        $sUT->setMediaType($mediaType);
        $sUT->addRequired($required);
        $sUT->setTitle($title);
        $sUT->setType($type);

        $this->assertEquals($description, $sUT->getDescription());
        $this->assertEquals($dollarSchema, $sUT->getDollarSchema());
        $this->assertEquals($id, $sUT->getId());
        $this->assertEquals($mediaType, $sUT->getMediaType());
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

        $sUT->addItem('test', new Item(), false);

        $this->assertSame(1, count($sUT->getItems()));

        $this->setExpectedException('JSONSchema\Structure\Exceptions\OverwriteKeyException');

        $sUT->addItem('test', new Item(), false);
    }

    public function testKeywordManipulation()
    {
        $sUT = new Schema();

        $sUT->addKeyword('test', 'myval');

        $items = $sUT->getKeywords();

        $this->assertSame(1, count($items));

        $sUT->addKeyword('test', 'myval2');

        $this->assertSame(1, count($sUT->getKeywords()));

        $sUT->removeKeyword('test');

        $this->assertSame(0, count($sUT->getKeywords()));

        $sUT->addKeyword('test', 'myval', false);

        $this->assertSame(1, count($sUT->getKeywords()));

        $this->setExpectedException('JSONSchema\Structure\Exceptions\OverwriteKeyException');

        $sUT->addKeyword('test', 'myval3', false);
    }

    public function testPropertiesManipulation()
    {
        $sUT = new Schema();

        $sUT->addProperty('test', new Property());

        $items = $sUT->getProperties();

        $this->assertSame(1, count($items));

        $sUT->addProperty('test', new Property());

        $this->assertSame(1, count($sUT->getProperties()));

        $sUT->removeProperty('test');

        $this->assertSame(0, count($sUT->getProperties()));

        $sUT->addProperty('test', new Property(), false);

        $this->assertSame(1, count($sUT->getProperties()));

        $this->setExpectedException('JSONSchema\Structure\Exceptions\OverwriteKeyException');

        $sUT->addProperty('test', new Property(), false);
    }

    public function testToString()
    {
        $sUT = new Schema();

        $sUT->addProperty('test', new Property());
        $sUT->addKeyword('test', 'myval2');
        $sUT->addItem('test', new Item());

        $this->assertInternalType('string', $sUT->toString());
    }

    public function testToArray()
    {
        $sUT = new Schema();

        $sUT->addProperty('test', new Property());
        $sUT->addKeyword('test', 'myval2');
        $sUT->addItem('test', new Item());

        $this->assertInternalType('array', $sUT->toArray());
    }
}
