<?php
namespace JSONSchema\Tests\SchemaGenerator;

use JSONSchema\SchemaGenerator;

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
        ->willReturn($parserMock);

        $parserFactory->expects($this->once())
        ->method('getParser')
        ->willReturn($parserMock);

        $sUT = new SchemaGenerator($parserFactory);

        $this->assertEquals($parserMock, $sUT->parse('my data !'));
    }
}