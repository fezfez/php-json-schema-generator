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
     * by default we should probably assume
     * that this is going to deliver as a JSON object
     *
     * @var boolean $isJSONObject
     */
    protected $isJSONObject = true;

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
        if (isset($config['isJSONObject']) === true) {
            $this->isJSONObject = $config['isJSONObject'];
        }

        $this->config = $config;
        $this->loadSchema();
        $this->doParse($subject);

        return $this->schemaObject;
    }

    /**
     * @param string $subject
     */
    abstract protected function doParse($subject);
    /**
     * @param mixed $data
     * @return boolean
     */
    abstract public function isValidType($data);

    /**
     * basically set up the schema object with the properties
     * provided in the config
     * most items are defaulted as they are probably domain specific
     *
     * @throws InvalidConfigItemException
     */
    protected function loadSchema()
    {
        $this->schemaObject = new Schema();

        $configsKeys = array(
            'schema_dollarSchema' => 'setDollarSchema',
            'schema_required'     => 'setRequired',
            'schema_title'        => 'setTitle',
            'schema_description'  => 'setDescription',
            'schema_type'         => 'setType'
        );

        foreach ($configsKeys as $key => $method) {
            if(isset($this->config[$key]) === true) {
                $this->schemaObject->$method($this->config[$key]);
            }
        }

        return $this;
    }

    /**
     * @param string $key
     */
    protected function getConfig($key)
    {
        if (isset($this->config[$key]) === false || is_string($key) === false) {
            throw new InvalidConfigItemException("They key: $key is not set ");
        }

        return $this->config[$key];
    }

    /**
     * @param string $key
     * @return boolean
     */
    protected function configExists($key)
    {
        return isset($this->config[$key]);
    }
}
