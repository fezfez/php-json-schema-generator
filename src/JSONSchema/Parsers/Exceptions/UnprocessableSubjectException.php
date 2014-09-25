<?php
namespace JSONSchema\Parsers\Exceptions;

/**
 * @package JSONSchema\Parsers\Exceptions
 * @author steven
 */
class UnprocessableSubjectException extends \RuntimeException
{
    /**
     * @param string $message
     */
    public function __construct($message = "The provided subject could not be processed")
    {
        parent::__construct($message);
    }
}
