<?php
namespace JSONSchema\Parsers;

use JSONSchema\Parsers\Exceptions\NoParserFoundException;

/**
 * Helps in loading up the proper parser for the data type provided
 *
 *
 * @name ParserFactory
 * @author solvire
 * @package JSONSchema\Parsers
 * @subpackage Parsers
 *
 */
class ParserFactory
{
    /**
     * @var array
     */
    private $parserCollection = array();

    /**
     * @param array $parserCollection
     */
    public function __construct(array $parserCollection)
    {
        $this->parserCollection = $parserCollection;
    }

    /**
     * @param mixed $data
     * @throws \InvalidArgumentException
     * @return \JSONSchema\Parsers\Parser
     */
    public function getParser($data)
    {
        foreach ($this->parserCollection as $parser) {
            if ($parser->isValidType($data) === true) {
                return $parser;
            }
        }

        throw new \InvalidArgumentException(sprintf('The type "%s" is not supported ', gettype($data)));
    }
}
