<?php
namespace JSONSchema\Parsers\Exceptions;

/**
 * @package JSONSchema\Parsers\Exceptions
 * @author steven
 */
class InvalidConfigItemException extends \RuntimeException
{
    /**
     * @param string $message
     * @param string $code
     * @param string $previous
     */
    public function __construct($message = "The config item is invalid", $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
