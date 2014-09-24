<?php
namespace JSONSchema\Tests\Parsers\ParserFactory;

use JSONSchema\Parsers\ParserFactory;

class GetParserTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowExceptionWhenTypeNoValid()
    {
        $data = 'my data !';
        $parserMock = $this->getMockForAbstractClass('JSONSchema\Parsers\Parser');

        $parserMock->expects($this->once())
        ->method('isValidType')
        ->with($data)
        ->willReturn(false);

        $sUT = new ParserFactory(array($parserMock));

        $this->setExpectedException('JSONSchema\Parsers\Exceptions\NoParserFoundException');

        $sUT->getParser($data);
    }

    public function testReturnWhenValid()
    {
        $data = 'my data !';
        $parserMock = $this->getMockForAbstractClass('JSONSchema\Parsers\Parser');

        $parserMock->expects($this->once())
        ->method('isValidType')
        ->with($data)
        ->willReturn(true);

        $sUT = new ParserFactory(array($parserMock));

        $this->assertEquals($parserMock, $sUT->getParser($data));
    }
}