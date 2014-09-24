<?php
namespace JSONSchema\Tests\SchemaGeneratorFactory;

use JSONSchema\SchemaGeneratorFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf('JSONSchema\SchemaGenerator', SchemaGeneratorFactory::getInstance());
    }
}