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
class Property
{

    /**
     * link to the resource identifier
     *
     * @var string $id
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $type = '';

    /**
     * property key - array like
     * @var string
     */
    protected $key = '';

    /**
     *
     * @var string
     */
    protected $name = '';

    /**
     *
     * @var string
     */
    protected $title = '';

    /**
     *
     * @var string
     */
    protected $description = '';

    /**
     * needs to be allowed to be set as a default config setting
     *
     * @var boolean
     */
    protected $required = false;

    /**
     * When numeric it's integer min or max
     * When it's array it's min/max items
     *
     * @var integer
     */
    protected $min = 0;

    /**
     * When numeric it's integer min or max
     * When it's array it's min/max items
     *
     * @var integer
     */
    protected $max = 0;

    /**
     * sub properties
     *
     * @var array
     */
    protected $properties = array();


    /**
     * sub items
     *
     * @var array
     */
    protected $items = array();

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
     * @return the $key
     */
    public function getKey()
    {
        return $this->key;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
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
     * @return the $required
     */
    public function getRequired()
    {
        return $this->required;
    }

	/**
     * @return the $min
     */
    public function getMin()
    {
        return $this->min;
    }

	/**
     * @return the $max
     */
    public function getMax()
    {
        return $this->max;
    }

	/**
     * @return the $properties
     */
    public function getProperties()
    {
        return $this->properties;
    }

	/**
     * @return the $items
     */
    public function getItems()
    {
        return $this->items;
    }

	/**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

	/**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @param boolean $required
     */
    public function setRequired($required = false)
    {
        $this->required = $required;
        return $this;
    }

	/**
     * @param integer $min
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

	/**
     * @param integer $max
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
     * @return $this
     * @throws Exceptions\OverwriteKeyException
     */
    public function addProperty($key, Property $value, $overwrite = true)
    {
        if (array_key_exists($key, $this->properties) && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->properties[$key] = $value;
        return $this;
    }


    /**
     * @param string $key
     * @param Item $value
     * @param boolean $overwrite
     * @return $this
     * @throws Exceptions\OverwriteKeyException
     */
    public function addItem($key, Item $value, $overwrite = true)
    {
        if (array_key_exists($key, $this->items) && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->items[$key] = $value;

        return $this;
    }

    /**
     * @param string $parentId - identifier for the parent element
     * @return array fields
     */
    public function toObject($parentId = null)
    {
        $stdClass = new \stdClass();

        $stdClass->id          = $this->id !== null ? $this->getId() : $parentId . '/' . $this->name;
        $stdClass->type        = $this->type;
        $stdClass->required    = $this->required;
        $stdClass->title       = $this->title;
        $stdClass->description = $this->description;

        if($stdClass->type === PropertyTypeMapper::INTEGER_TYPE ||
           $stdClass->type === PropertyTypeMapper::NUMBER_TYPE )
        {
            if(empty($this->min) === false) $stdClass->min = $this->getMin();
            if(empty($this->max) === false) $stdClass->max = $this->getMax();
        }

        if (count($this->items) !== 0) {
            $stdClass->items = array();
            foreach($this->items as $key => $item) {
                $stdClass->items[] = $item->toObject($this->id);
            }
        }

        if (count($this->properties) !== 0) {
            $stdClass->properties  = array();
            foreach($this->properties as $key => $property) {
                $stdClass->properties[$key] = $property->toObject($this->id);
            }
        }

        return $stdClass;
    }

}
