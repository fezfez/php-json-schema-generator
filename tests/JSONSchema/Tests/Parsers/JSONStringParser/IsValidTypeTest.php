<?php
namespace JSONSchema\Tests\Parsers\JSONStringParse;

use JSONSchema\Parsers\JSONStringParser;

class IsValidTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValid()
    {
        $sUT = new JSONStringParser();

        $this->assertEquals(true, $sUT->isValidType('test'));
    }

    public function testIsNotValid()
    {
        $sUT = new JSONStringParser();

        $this->assertEquals(false, $sUT->isValidType(55));
    }
}
