<?php
namespace JSONSchema\Tests\SchemaGenerator;

use JSONSchema\SchemaGenerator;
use JSONSchema\Structure\Schema;

class ParseTest extends \PHPUnit_Framework_TestCase
{
    public function testParseIsWellCall()
    {
        $parserFactory = $this->getMockBuilder('JSONSchema\Parsers\ParserFactory')
        ->disableOriginalConstructor()
        ->getMock();

        $parserMock = $this->getMockBuilder('JSONSchema\Parsers\JSONStringParser')
        ->disableOriginalConstructor()
        ->getMock();

        $data = 'my data !';

        $parserMock->expects($this->once())
        ->method('parse')
        ->with($data)
        ->will($this->returnValue(new Schema()));

        $parserFactory->expects($this->once())
        ->method('getParser')
        ->with($data)
        ->will($this->returnValue($parserMock));

        $sUT = new SchemaGenerator($parserFactory);

        $this->assertInstanceOf('JSONSchema\Structure\Schema', $sUT->parse($data));
    }
}