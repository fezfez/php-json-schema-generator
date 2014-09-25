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
     * @var array $properties
     */
    protected $properties = array();

    /**
     * Special use case
     * JSON Array
     *
     * @var array $items
     */
    protected $items = array();

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
     * properties or items in a list which are required
     * @var array $required
     */
    protected $required = array();

    /**
     * @var string $title
     */
    protected $title  = '';

    /**
     * @var string $description
     */
    protected $description = '';

    /**
     * the JSON primitive type
     * Default MUST be object type
     * Section 3.2
     *
     * @var string $type
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
     * @param boolean $overwrite
     * @return $this
     * @throws Exceptions\OverwriteKeyException
     */
    public function addKeyword($key,$value,$overwrite = true)
    {
        if(!empty($this->keywords[$key]) && !$overwrite)
            throw new Exceptions\OverwriteKeyException();

        $this->keywords[$key] = $value;
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
        if(!empty($this->properties[$key]) && !$overwrite)
            throw new Exceptions\OverwriteKeyException();

        $value->setId($this->getId() . '/' . $key);
        $this->properties[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @param boolean $overwrite
     * @return $this
     * @throws Exceptions\OverwriteKeyException
     */
    public function addItem($key, Item $value, $overwrite = true)
    {
        if(!empty($this->items[$key]) && !$overwrite)
            throw new Exceptions\OverwriteKeyException();

        $this->items[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeKeyword($key)
    {
        unset($this->keywords[$key]);
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */

    public function removeProperty($key)
    {
        unset($this->properties[$key]);
        return $this;
    }

    /**
     * @param string $key
     * @return $this
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
     * @return the $dollarSchema
     */
    public function getDollarSchema()
    {
        return $this->dollarSchema;
    }

    /**
     * @return $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $required
     */
    public function getRequired()
    {
        return $this->required;
    }

	/**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

	/**
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

	/**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

	/**
     * @return the $mediaType
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

	/**
     * @param string $dollarSchema
     */
    public function setDollarSchema($dollarSchema)
    {
        $this->dollarSchema = $dollarSchema;
        return $this;
    }

    /**
     *
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

	/**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

	/**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

	/**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

	/**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

	/**
     * @param string $mediaType
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