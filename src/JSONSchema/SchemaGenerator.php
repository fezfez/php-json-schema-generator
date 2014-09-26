<?php

namespace JSONSchema;

use JSONSchema\Parsers\ParserFactory;

/**
 *
 * JSON Schema Generator
 *
 * Duties:
 * Take object arguments
 * Factory load appropriate parser
 *
 *
 * @package JSONSchema
 * @author solvire
 *
 */
class SchemaGenerator
{
    /**
     * @var ParserFactory
     */
    private $parserFactory = null;

    /**
     * @param ParserFactory $parserFactory
     */
    public function __construct(ParserFactory $parserFactory)
    {
        $this->parserFactory = $parserFactory;
    }

    /**
     * @param string $data
     * @return \JSONSchema\Structure\Schema
     */
    public function parse($data)
    {
        return $this->parserFactory->getParser($data)->parse($data);
    }
}
