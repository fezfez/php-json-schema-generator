<?php
namespace JSONSchema\Tests\Structure\Schema;

use JSONSchema\Structure\Schema;

class AllPropsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $sUT = new Schema();

        $description = 'im';
        $dollarSchema = 'a';
        $id = 'test';
        $mediaType = ',';
        $required = 'very';
        $title = 'super';
        $type = 'efficient';

        $sUT->setDescription($description);
        $sUT->setDollarSchema($dollarSchema);
        $sUT->setId($id);
        $sUT->setMediaType($mediaType);
        $sUT->setRequired($required);
        $sUT->setTitle($title);
        $sUT->setType($type);

        $this->assertEquals($description, $sUT->getDescription());
        $this->assertEquals($dollarSchema, $sUT->getDollarSchema());
        $this->assertEquals($id, $sUT->getId());
        $this->assertEquals($mediaType, $sUT->getMediaType());
        $this->assertEquals($required, $sUT->getRequired());
        $this->assertEquals($title, $sUT->getTitle());
        $this->assertEquals($type, $sUT->getType());
    }
}