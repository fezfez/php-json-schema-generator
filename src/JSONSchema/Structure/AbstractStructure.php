<?php
namespace JSONSchema\Structure;

abstract class AbstractStructure
{
    /**
     * the ID is a string reference to the resource that is identified in this document
     * As this JSON document is defined the base URL should be provided and set otherwise
     * the json schema
     *
     * @var string $id
     */
    private $id = 'http://jsonschema.net';

    /**
     * the JSON primitive type
     * Default MUST be object type
     * Section 3.2
     *
     * @var string
     */
    private $type = 'object';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var string
     */
    private $name = '';

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
     * @param string $id
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $type
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $title
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $name
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param boolean $value
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function setAdditionalProperties($value)
    {
        $this->additionalProperties = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function addRequired($key)
    {
        $this->required[] = $key;
        return $this;
    }

    /**
     * @param string $key
     * @param Property $value
     * @param string $overwrite
     * @throws Exceptions\OverwriteKeyException
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function addProperty($key, Property $value, $requiredByDefault = false, $overwrite = true)
    {
        if(array_key_exists($key, $this->properties) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $value->setId($this->getId() . '/' . $key);

        $this->properties[$key] = $value;

        if ($requiredByDefault === true) {
            $this->required[] = $key;
        }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function hasAdditionalProperties()
    {
        return $this->additionalProperties;
    }

    /**
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param string $key
     * @return \JSONSchema\Structure\AbstractStructure
     */
    public function removeProperty($key)
    {
        unset($this->properties[$key]);

        if (false !== $requireKey = array_search($key, $this->required)) {
            unset($this->required[$requireKey]);
        }

        return $this;
    }

    /**
     * @param array $data
     * @param array $array
     * @param string $name
     * @param string $id
     * @return array
     */
    public function hydrateCollection(array $data, array $array, $name, $id = null)
    {
        if (count($data) !== 0) {
            $array[$name] = array();
            foreach($data as $key => $property) {
                $array[$name][$key] = $property->toObject($id);
            }
        }

        return $array;
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
     * A array representation of Schema
     * @return string
     */
    public function toArray()
    {
        return (array) $this->toObject();
    }

    /**
     * @param string $parentId
     * @return \stdClass
     */
    abstract public function toObject($parentId = null);
}
