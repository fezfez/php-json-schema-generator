<?php
namespace JSONSchema\Parsers\Exceptions;

/**
 * @author solvire
 */
class NoParserFoundException extends \RuntimeException
{
    /**
     * @param string $message
     */
    public function __construct($message = "Parser not found")
    {
        parent::__construct($message);
    }
}
