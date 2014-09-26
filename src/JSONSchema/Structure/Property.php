<?php
namespace JSONSchema\Structure;

use JSONSchema\Mappers\PropertyTypeMapper;

/**
 * Represents a Property or Member as defined
 *
 * @link http://tools.ietf.org/html/draft-zyp-json-schema-04#section-3.1
 * @link http://tools.ietf.org/html/rfc4627
 * @author steven
 *
 */
class Property extends AbstractStructure
{
    /**
     * When numeric it's integer min or max
     * When it's array it's min/max items
     *
     * @var integer
     */
    private $min = 0;

    /**
     * When numeric it's integer min or max
     * When it's array it's min/max items
     *
     * @var integer
     */
    private $max = 0;

    /**
     * sub items
     *
     * @var array
     */
    private $items = array();

    /**
     * @param integer $min
     * @return \JSONSchema\Structure\Property
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @param integer $max
     * @return \JSONSchema\Structure\Property
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @param string $key
     * @param Item $value
     * @param boolean $overwrite
     * @return \JSONSchema\Structure\Property
     * @throws Exceptions\OverwriteKeyException
     */
    public function addItem($key, Item $value, $requiredByDefault = false, $overwrite = true)
    {
        if (array_key_exists($key, $this->items) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->items[$key] = $value;

        if ($requiredByDefault === true) {
            $this->addRequired($key);
        }

        return $this;
    }

    /**
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string $parentId - identifier for the parent element
     * @return \stdClass
     */
    public function toObject($parentId = null)
    {
        $array = array(
            'id'          => $this->getId(),
            'type'        => $this->getType(),
            'title'       => $this->getTitle(),
            'description' => $this->getDescription(),
            'required'    => $this->getRequired()
        );

        $array = $this->hydrateNumericTypes($array);
        $array = $this->hydrateCollection($this->getItems(), $array, 'items');
        $array = $this->hydrateCollection($this->getProperties(), $array, 'properties');

        $array['required'] = $this->getRequired();

        return (object) $array;
    }

    /**
     * @param array $array
     * @return $array
     */
    private function hydrateNumericTypes(array $array)
    {
        $numericType = array(PropertyTypeMapper::INTEGER_TYPE, PropertyTypeMapper::NUMBER_TYPE);

        if (in_array($array['type'], $numericType) === true) {
            if(empty($this->min) === false) $array['min'] = $this->getMin();
            if(empty($this->max) === false) $array['max'] = $this->getMax();
        }

        return $array;
    }
}
