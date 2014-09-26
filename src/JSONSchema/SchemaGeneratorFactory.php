<?php

namespace JSONSchema;

use JSONSchema\Parsers\ParserFactory;
use JSONSchema\Parsers\JSONStringParser;

class SchemaGeneratorFactory
{
    /**
     * @return \JSONSchema\SchemaGenerator
     */
    public static function getInstance()
    {
        return new SchemaGenerator(
            new ParserFactory(
                array(
                    new JSONStringParser()
                )
            )
        );
    }
}
