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

    public function testParsingWithConfig()
    {
        $sUT = new JSONStringParser();

        $config = array(
            'fake' => 'config'
        );

        $this->assertInstanceOf('JSONSchema\Structure\Schema', $sUT->parse('{"test" : "toto"}', $config));
    }

    public function testStringRepresentation()
    {
        $sUT = new JSONStringParser();

        $config = array(
            'fake' => 'config'
        );

        $json = '
{
    "test": "toto",
    "antoher": [
        {
            "other": "test",
            "in": {
                "test": "hoho"
            },
            "aboolean" : true,
            "integer" : 10,
            "float" : 1.2,
            "nullone" : null
        }
    ]
}';

        $this->assertInternalType('string', $sUT->parse($json, $config)->toString());
    }

    public function testArrayRepresentation()
    {
        $sUT = new JSONStringParser();

        $config = array(
            'fake' => 'config'
        );

        $this->assertInternalType('array', $sUT->parse('{"test" : "toto"}', $config)->toArray());
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