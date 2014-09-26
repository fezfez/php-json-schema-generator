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
     * link to the resource identifier
     *
     * @var string $id
     */
    private $id = null;

    /**
     * @var string
     */
    private $type = '';

    /**
     * property key - array like
     * @var string
     */
    private $key = '';

    /**
     *
     * @var string
     */
    private $name = '';

    /**
     *
     * @var string
     */
    private $title = '';

    /**
     *
     * @var string
     */
    private $description = '';

    /**
     * needs to be allowed to be set as a default config setting
     *
     * @var boolean
     */
    private $required = false;

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
     * sub properties
     *
     * @var array
     */
    private $properties = array();

    /**
     * sub items
     *
     * @var array
     */
    private $items = array();

    /**
     * @param string $parentId
     * @return string
     */
    public function getId($parentId = null)
    {
        return $this->id !== null ? $this->id : $parentId . '/' . $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
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
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string $id
     * @return \JSONSchema\Structure\Property
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $type
     * @return \JSONSchema\Structure\Property
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\Property
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $name
     * @return \JSONSchema\Structure\Property
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $title
     * @return \JSONSchema\Structure\Property
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $description
     * @return \JSONSchema\Structure\Property
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param boolean $required
     * @return \JSONSchema\Structure\Property
     */
    public function setRequired($required = false)
    {
        $this->required = $required;

        return $this;
    }

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
     * @param Property $value
     * @param boolean $overwrite
     * @return \JSONSchema\Structure\Property
     * @throws Exceptions\OverwriteKeyException
     */
    public function addProperty($key, Property $value, $overwrite = true)
    {
        if (array_key_exists($key, $this->properties) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->properties[$key] = $value;
        return $this;
    }


    /**
     * @param string $key
     * @param Item $value
     * @param boolean $overwrite
     * @return \JSONSchema\Structure\Property
     * @throws Exceptions\OverwriteKeyException
     */
    public function addItem($key, Item $value, $overwrite = true)
    {
        if (array_key_exists($key, $this->items) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->items[$key] = $value;

        return $this;
    }

    /**
     * @param string $parentId - identifier for the parent element
     * @return \stdClass
     */
    public function toObject($parentId = null)
    {
        $array = array(
            'id'          => $this->getId($parentId),
            'type'        => $this->type,
            'title'       => $this->title,
            'description' => $this->description,
            'required'    => $this->required
        );

        $array = $this->hydrateNumericTypes($array);
        $array = $this->hydrateCollection($this->items, $array, 'items');
        $array = $this->hydrateCollection($this->properties, $array, 'properties');

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
