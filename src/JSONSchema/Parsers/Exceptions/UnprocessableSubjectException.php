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
     * @param string $code
     * @param string $previous
     */
    public function __construct(
        $message = "The provided subject could not be processed",
        $code = null,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
