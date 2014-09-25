<?php
namespace JSONSchema\Structure;

/**
 * A JSON document
 * Represents the body of the schema
 * Can be decomposed and consolidated as a simple array of key values for easy json_encoding
 *
 * @link http://tools.ietf.org/html/draft-zyp-json-schema-04#section-3.2
 * @author steven
 *
 */
use JSONSchema\Mappers\PropertyTypeMapper;

class Schema
{

    /**
     * From section 3.2
     * Object members are keywords
     *
     * @var array
     */
    protected $keywords = array();

    /**
     * Properties
     *
     * @var array
     */
    protected $properties = array();

    /**
     * Special use case JSON Array
     *
     * @var array
     */
    protected $items = array();

    /**
     * properties or items in a list which are required
     * @var array
     */
    protected $required = array();

    /**
     * @var string
     */
    protected $dollarSchema  = 'http://json-schema.org/draft-04/schema';

    /**
     * the ID is a string reference to the resource that is identified in this document
     * As this JSON document is defined the base URL should be provided and set otherwise
     * the json schema
     *
     * @var string $id
     */
    protected $id = 'http://jsonschema.net';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * the JSON primitive type
     * Default MUST be object type
     * Section 3.2
     *
     * @var string
     */
    protected $type = 'object';

    /**
     * type of media content
     * @var string
     */
    protected $mediaType = 'application/schema+json';

    /**
     * during the return it can clean up empty fields
     * @var boolean
     */
    protected $pruneEmptyFields = true;

    /**
     * @param string $key
     * @param string $value
     * @param string $overwrite
     * @throws Exceptions\OverwriteKeyException
     * @return \JSONSchema\Structure\Schema
     */
    public function addKeyword($key, $value, $overwrite = true)
    {
        if(array_key_exists($key, $this->keywords) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->keywords[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param Property $value
     * @param string $overwrite
     * @throws Exceptions\OverwriteKeyException
     * @return \JSONSchema\Structure\Schema
     */
    public function addProperty($key, Property $value, $overwrite = true)
    {
        if(array_key_exists($key, $this->properties) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $value->setId($this->getId() . '/' . $key);
        $this->properties[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param Item $value
     * @param boolean $overwrite
     * @throws Exceptions\OverwriteKeyException
     * @return \JSONSchema\Structure\Schema
     */
    public function addItem($key, Item $value, $overwrite = true)
    {
        if(array_key_exists($key, $this->items) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->items[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\Schema
     */
    public function removeKeyword($key)
    {
        unset($this->keywords[$key]);
        return $this;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\Schema
     */
    public function removeProperty($key)
    {
        unset($this->properties[$key]);
        return $this;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\Schema
     */
    public function removeItem($key)
    {
        unset($this->items[$key]);
        return $this;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
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
     * @return string
     */
    public function getDollarSchema()
    {
        return $this->dollarSchema;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * @param string $dollarSchema
     * @return \JSONSchema\Structure\Schema
     */
    public function setDollarSchema($dollarSchema)
    {
        $this->dollarSchema = $dollarSchema;
        return $this;
    }

    /**
     * @param integer $id
     * @return \JSONSchema\Structure\Schema
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\Schema
     */
    public function addRequired($key)
    {
        $this->required[] = $key;
        return $this;
    }

    /**
     * @param string $title
     * @return \JSONSchema\Structure\Schema
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return \JSONSchema\Structure\Schema
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $type
     * @return \JSONSchema\Structure\Schema
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $mediaType
     * @return \JSONSchema\Structure\Schema
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    /**
     * A string representation of this Schema
     * @return string
     */
    public function toString()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    /**
     * Main schema generation utility
     *
     * @return array list of fields and values including the properties/items
     */
    public function toArray()
    {
        $array = array(
            'id'          => $this->id,
            'schema'      => $this->dollarSchema,
            'required'    => $this->required,
            'title'       => $this->title,
            'description' => $this->description,
            'type'        => $this->type,
            'mediaType'   => $this->mediaType,
            'items'       => array(),
            'properties'  => array()
        );

        foreach($this->getItems() as $key => $item) {
            $array['items'][] = $item->loadFields($this->id);
        }

        foreach($this->getProperties() as $key => $property) {
            $array['properties'][$key] = $property->loadFields();
        }

        return $array;
    }
}