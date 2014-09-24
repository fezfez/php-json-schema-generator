<?php
namespace JSONSchema\Tests\Parsers\JSONStringParse;

use JSONSchema\Parsers\JSONStringParser;

class ParseTest extends \PHPUnit_Framework_TestCase
{
    public function testParsingFail()
    {
        $sUT = new JSONStringParser();

        $this->setExpectedException('JSONSchema\Parsers\Exceptions\UnprocessableSubjectException');
        $sUT->parse('invalid json !');
    }

    public function testParsingSimple()
    {
        $sUT = new JSONStringParser();

        $this->assertInstanceOf('JSONSchema\Structure\Schema', $sUT->parse('{"test" : "toto"}'));
    }

    public function testComplex()
    {
        $sUT = new JSONStringParser();

        $this->assertInstanceOf(
            'JSONSchema\Structure\Schema',
            $sUT->parse(file_get_contents(DATA_PATH . 'example.address1.json'))
        );
        $this->assertInstanceOf(
            'JSONSchema\Structure\Schema',
            $sUT->parse(file_get_contents(DATA_PATH . 'example.address2.json'))
        );
        $this->assertInstanceOf(
            'JSONSchema\Structure\Schema',
            $sUT->parse(file_get_contents(DATA_PATH . 'facebook-data.json'))
        );
    }
}