<?php
namespace JSONSchema\Structure;

/**
 * Represents an Item or Element as defined
 * JSON Array Item
 *
 * @link http://tools.ietf.org/html/draft-zyp-json-schema-04#section-3.1
 * @link http://tools.ietf.org/html/rfc4627
 * @author steven
 *
 */
class Item extends AbstractStructure
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
     * @var boolean
     */
    private $additionalProperties = false;

    /**
     * @var array
     */
    private $required = array();

    /**
     * @var array
     */
    private $properties = array();

    /**
     * @param string $value
     * @return \JSONSchema\Structure\Item
     */
    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }
    /**
     * @param string $value
     * @return \JSONSchema\Structure\Item
     */
    public function setType($value)
    {
        $this->type = $value;

        return $this;
    }
    /**
     * @param boolean $value
     * @return \JSONSchema\Structure\Item
     */
    public function setAdditionalProperties($value)
    {
        $this->additionalProperties = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\Item
     */
    public function addRequired($key)
    {
        $this->required[] = $key;

        return $this;
    }

    /**
     * @param string $key
     * @param Property $value
     * @param boolean $overwrite
     * @return $this
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return boolean
     */
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }

    /* (non-PHPdoc)
     * @see \JSONSchema\Structure\Property::getRequired()
     */
    public function getRequired()
    {
        return $this->required;
    }

    /* (non-PHPdoc)
     * @see \JSONSchema\Structure\Property::getProperties()
     */
    public function getProperties()
    {
        return $this->properties;
    }
    /**
     * Because the Item structure is of Array type we
     * need to pass in the parent ID differently
     * For now we can just hard code an :id field but later
     * it needs to have keys for various reasons
     *
     * @see JSONSchema\Structure.Property::toObject()
     */
    public function toObject($parentId = null)
    {
        $array = array(
            'id'                   => $this->id,
            'type'                 => $this->type,
            'additionalProperties' => $this->additionalProperties
        );

        $array = $this->hydrateCollection($this->properties, $array, 'properties');

        $array['required'] = $this->required;

        return (object) $array;
    }
}
