<?php
namespace JSONSchema\Tests\Parsers\JSONStringParse;

use JSONSchema\Parsers\JSONStringParser;
use JsonSchema\Validator;

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

        $json = '{"test" : "toto"}';
        $validator = new Validator();

        $results = $sUT->parse($json, $config);
        $this->assertInstanceOf('JSONSchema\Structure\Schema', $results);

        $validator->check(json_decode($json), $results->toObject());

        $this->assertTrue(
            $validator->isValid(),
            "\n Error : " . json_encode($validator->getErrors()) .
            "\njson : " . $json .
            "\nschema : " . $results->toString()
        );
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
    ],
    "simpleArray": ["test"]
}';

        $validator = new Validator();

        $results = $sUT->parse($json, $config);
        $this->assertInstanceOf('JSONSchema\Structure\Schema', $results);

        $validator->check(json_decode($json), $results->toObject());

        $this->assertTrue(
            $validator->isValid(),
            "\n Error : " . json_encode($validator->getErrors()) .
            "\njson : " . $json .
            "\nschema : " . $results->toString()
        );
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
        $jsonArray = array(
            DATA_PATH . 'example.address1.json',
            DATA_PATH . 'example.address2.json',
            DATA_PATH . 'facebook-data.json'
        );

        foreach ($jsonArray as $jsonUrl) {
            $sUT       = new JSONStringParser();
            $validator = new Validator();
            $json      = file_get_contents($jsonUrl);
            $results   = $sUT->parse($json);

            $this->assertInstanceOf('JSONSchema\Structure\Schema', $results);

            $validator->check(
                json_decode($json),
                $results->toObject()
            );
            $this->assertTrue(
                $validator->isValid(),
                "\n Error : " . json_encode($validator->getErrors()) .
                "\njson : " . $json .
                "\nschema : " . $results->toString()
            );
        }
    }
}