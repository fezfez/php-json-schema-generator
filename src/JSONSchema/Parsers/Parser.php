<?php
namespace JSONSchema\Parsers;

use JSONSchema\Structure\Schema;

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
     * @param mixed $subject
     * @param Config $config
     * @return \JSONSchema\Structure\Schema
     */
    public function parse($subject, Config $config = null)
    {
        $schemaObject = new Schema();
        $schemaObject->setConfig(($config === null) ? new Config() : $config);

        return $this->doParse($subject, $schemaObject);
    }

    /**
     * @param string $subject
     * @return Schema
     */
    abstract protected function doParse($subject, Schema $schema);
    /**
     * @param mixed $data
     * @return boolean
     */
    abstract public function isValidType($data);
}
