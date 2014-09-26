<?php
namespace JSONSchema\Structure;

use JSONSchema\Parsers\Config;

/**
 * A JSON document
 * Represents the body of the schema
 * Can be decomposed and consolidated as a simple array of key values for easy json_encoding
 *
 * @link http://tools.ietf.org/html/draft-zyp-json-schema-04#section-3.2
 * @author steven
 *
 */
class Schema extends AbstractStructure
{
    /**
     * From section 3.2
     * Object members are keywords
     *
     * @var array
     */
    private $keywords = array();

    /**
     * Properties
     *
     * @var array
     */
    private $properties = array();

    /**
     * Special use case JSON Array
     *
     * @var array
     */
    private $items = array();

    /**
     * properties or items in a list which are required
     * @var array
     */
    private $required = array();

    /**
     * @var string
     */
    private $dollarSchema = 'http://json-schema.org/draft-04/schema';

    /**
     * the ID is a string reference to the resource that is identified in this document
     * As this JSON document is defined the base URL should be provided and set otherwise
     * the json schema
     *
     * @var string $id
     */
    private $id = 'http://jsonschema.net';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * the JSON primitive type
     * Default MUST be object type
     * Section 3.2
     *
     * @var string
     */
    private $type = 'object';

    /**
     * type of media content
     * @var string
     */
    private $mediaType = 'application/schema+json';

    /**
     * @var Config
     */
    private $config = null;

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
     * @return \JSONSchema\Parsers\Config
     */
    public function getConfig()
    {
        return $this->config;
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
     * @param string $id
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
     * @param Config $config
     * @return \JSONSchema\Structure\Schema
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Main schema generation utility
     *
     * @return \stdClass
     */
    public function toObject($parentId = null)
    {
        $array = array(
            '$schema'     => $this->dollarSchema,
            'id'          => $this->id,
            'type'        => $this->type,
            'title'       => $this->title,
            'description' => $this->description,
            'mediaType'   => $this->mediaType
        );

        $array = $this->hydrateCollection($this->items, $array, 'items');
        $array = $this->hydrateCollection($this->properties, $array, 'properties');

        $array['required'] = $this->required;

        return (object) $array;
    }
}
