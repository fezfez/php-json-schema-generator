<?php
namespace JSONSchema\Mappers\Exceptions;

/**
 * @package JSONSchema\Structure\Exceptions
 * @author steven
 */
class UnmappableException extends \InvalidArgumentException
{
    /**
     * @param string $message
     * @param string $code
     * @param string $previous
     */
    public function __construct($message = "The parameter you provided is not mappable. ", $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
