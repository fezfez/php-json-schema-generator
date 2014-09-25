<?php
namespace JSONSchema\Mappers;

use JSONSchema\Mappers\Exceptions\UnmappableException;

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
     * the goal here would be go into a logic tree and work
     * from loosest definition to most strict
     *
     * @param mixed $property
     * @throws Exceptions\Unmappable
     * @return string
     */
    public static function map($property)
    {
        return ($type = gettype($property)) === 'double' ? self::NUMBER_TYPE : strtolower($type);
    }
}
