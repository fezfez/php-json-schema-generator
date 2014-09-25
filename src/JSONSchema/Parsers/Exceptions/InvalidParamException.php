<?php
namespace JSONSchema\Parsers\Exceptions;

/**
 * @package JSONSchema\Parsers\Exceptions
 * @author steven
 */
class InvalidParameterException extends \RuntimeException
{
    /**
     * @param string $message
     * @param string $code
     * @param string $previous
     */
    public function __construct(
        $message = "The provided parameter is not of valid type.",
        $code = null,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
