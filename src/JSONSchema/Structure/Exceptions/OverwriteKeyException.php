<?php
namespace JSONSchema\Structure\Exceptions;

/**
 * @package JSONSchema\Structure\Exceptions
 * @author steven
 */
class OverwriteKeyException extends \RuntimeException
{
    /**
     * @param string $message
     */
    public function __construct($message = "You are attempting to overwrite a key without forcing it to be. ")
    {
        parent::__construct($message);
    }
}
