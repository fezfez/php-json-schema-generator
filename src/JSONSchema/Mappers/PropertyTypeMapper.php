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
     * @var string
     */
    protected $property = null;

    /**
     * @param string $property
     */
    public function __construct($property)
    {
        if (false === is_string($property)) {
            new \InvalidArgumentException("Parameter provided must be a string");
        }

        $this->property = $property;
    }


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
//        if(!is_string($property))
//            throw new UnmappableException('The provided property must be a string.');
        // need to find a better way to determine what the string is
        switch ($property) {
            case (is_float($property) === true):
                return self::NUMBER_TYPE;
            case (is_int($property) === true):
                return self::INTEGER_TYPE;
            case (is_bool($property) === true):
                return self::BOOLEAN_TYPE;
            case (is_array($property) === true):
                return self::ARRAY_TYPE;
            case (is_null($property) === true):
                return self::NULL_TYPE;
            case (is_object($property) === true):
                return self::OBJECT_TYPE;
            case (is_string($property) === true):
                return self::STRING_TYPE;
            default:
                throw new UnmappableException("The provided argument property");
        }
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property();
    }
}
