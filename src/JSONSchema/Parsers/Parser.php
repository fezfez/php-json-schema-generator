<?php
namespace JSONSchema\Parsers;

use JSONSchema\Structure\Property;
use JSONSchema\Structure\Schema;
use JSONSchema\Structure\Item;
use JSONSchema\Parsers\Exceptions\NoStructureFoundException;
use JSONSchema\Parsers\Exceptions\InvalidConfigItemException;

/**
 * Main parser base class
 *
 * @author steven
 * @package JSONSchema\Parsers
 * @abstract
 */
abstract class Parser
{
    /**
     * place holder for the schema object
     * @var \JSONSchema\Structure\Schema $schemaObject
     */
    protected $schemaObject;

    /**
     * just config settings
     * TODO add a roster of config items
     * @var array $config
     */
    protected $config = array();

    /**
     * @param mixed $subject
     * @param array $config
     * @return \JSONSchema\Structure\Schema
     */
    public function parse($subject, array $config = array())
    {
        $this->config = $config;

        $schemaObject = new Schema();

        $configsKeys = array(
            'schema_dollarSchema' => 'setDollarSchema',
            'schema_title'        => 'setTitle',
            'schema_description'  => 'setDescription',
            'schema_type'         => 'setType'
        );

        foreach ($configsKeys as $key => $method) {
            if(isset($config[$key]) === true) {
                $schemaObject->$method($config[$key]);
            }
        }

        return $this->doParse($subject, $schemaObject);
    }

    /**
     * @param string $subject
     */
    abstract protected function doParse($subject, Schema $schema);
    /**
     * @param mixed $data
     * @return boolean
     */
    abstract public function isValidType($data);

    /**
     * @param string $key
     */
    protected function getConfig($key)
    {
        if (array_key_exists($key, $this->config) === false) {
            return null;
        }

        return $this->config[$key];
    }
}
