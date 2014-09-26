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
     * Special use case JSON Array
     *
     * @var array
     */
    private $items = array();

    /**
     * @var string
     */
    private $dollarSchema = 'http://json-schema.org/draft-04/schema';

    /**
     * @var Config
     */
    private $config = null;

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
     * @param Config $config
     * @return \JSONSchema\Structure\Schema
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param string $key
     * @param Item $value
     * @param boolean $overwrite
     * @throws Exceptions\OverwriteKeyException
     * @return \JSONSchema\Structure\Schema
     */
    public function addItem($key, Item $value, $requiredByDefault = false, $overwrite = true)
    {
        if(array_key_exists($key, $this->items) === true && $overwrite === false) {
            throw new Exceptions\OverwriteKeyException();
        }

        $this->items[$key] = $value;

        if ($requiredByDefault === true) {
            $this->addRequired($key);
        }

        return $this;
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
     * @return \JSONSchema\Parsers\Config
     */
    public function getConfig()
    {
        return $this->config;
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
     * Main schema generation utility
     *
     * @return \stdClass
     */
    public function toObject($parentId = null)
    {
        $array = array(
            '$schema'              => $this->getDollarSchema(),
            'id'                   => $this->getId(),
            'type'                 => $this->getType(),
            'title'                => $this->getTitle(),
            'description'          => $this->getDescription(),
            'name'                 => $this->getName(),
            'additionalProperties' => $this->hasAdditionalProperties()
        );

        $array = $this->hydrateCollection($this->getItems(), $array, 'items');
        $array = $this->hydrateCollection($this->getProperties(), $array, 'properties');

        $array['required'] = $this->getRequired();

        return (object) $array;
    }
}
