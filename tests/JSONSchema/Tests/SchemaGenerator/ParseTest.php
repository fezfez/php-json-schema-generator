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

        $parserMock = $this->getMockForAbstractClass('JSONSchema\Parsers\Parser');

        $parserMock->expects($this->once())
        ->method('parse')
        ->willReturn(new Schema());

        $parserFactory->expects($this->once())
        ->method('getParser')
        ->willReturn($parserMock);

        $sUT = new SchemaGenerator($parserFactory);

        $this->assertInstanceOf('JSONSchema\Structure\Schema', $sUT->parse('my data !'));
    }
}