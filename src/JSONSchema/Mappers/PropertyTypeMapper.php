<?php
namespace JSONSchema\Mappers;

/**
 *
 * @package JSONSchema\Mappers
 * @author steven
 *
 */
class PropertyTypeMapper
{
    // a little redundent but a nice key for hitting the arrays
    const ARRAY_TYPE   = 'array';
    const BOOLEAN_TYPE = 'boolean';
    const INTEGER_TYPE = 'integer';
    const NUMBER_TYPE  = 'number';
    const NULL_TYPE    = 'null';
    const OBJECT_TYPE  = 'object';
    const STRING_TYPE  = 'string';

    /**
     * @param mixed $property
     * @return string
     */
    public static function map($property)
    {
        return ($type = gettype($property)) === 'double' ? self::NUMBER_TYPE : strtolower($type);
    }
}
