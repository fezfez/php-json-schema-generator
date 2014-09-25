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
        if (is_int($property) === false && $property === null) {
            return self::NULL_TYPE;
        } elseif (is_float($property) === true) {
            return self::NUMBER_TYPE;
        } elseif (is_int($property) === true) {
            return self::INTEGER_TYPE;
        } elseif (is_bool($property) === true) {
            return self::BOOLEAN_TYPE;
        } elseif (is_array($property) === true) {
            return self::ARRAY_TYPE;
        } elseif (is_object($property) === true) {
            return self::OBJECT_TYPE;
        } elseif (is_string($property) === true) {
            return self::STRING_TYPE;
        }

        throw new UnmappableException("The provided argument property");
    }
}
