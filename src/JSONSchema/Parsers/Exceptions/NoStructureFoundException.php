<?php
namespace JSONSchema\Parsers\Exceptions;

/**
 * @author solvire
 */
class NoStructureFoundException extends \RuntimeException
{
    /**
     * @param string $message
     * @param string $code
     * @param string $previous
     */
    public function __construct($message = "Parser not found", $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
