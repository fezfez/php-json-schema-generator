<?php
namespace JSONSchema\Parsers;

use JSONSchema\Structure\Property;
use JSONSchema\Structure\Item;
use JSONSchema\Structure\Schema;
use JSONSchema\Parsers\Exceptions\InvalidParameterException;
use JSONSchema\Mappers\StringMapper;
use JSONSchema\Mappers\PropertyTypeMapper;

/**
 * @author steven
 */
class JSONStringParser extends Parser
{
    /**
     * @var array $itemFields
     */
    protected $itemFields = array();

    /* (non-PHPdoc)
     * @see \JSONSchema\Parsers\Parser::isValidType()
     */
    public function isValidType($data)
    {
        return is_string($data);
    }

    /**
     * (non-PHPdoc)
     * @see JSONSchema\Parsers.Parser::parse()
     */
    protected function doParse($subject, Schema $schema)
    {
        if(!$jsonObj = json_decode($subject)) {
            throw new Exceptions\UnprocessableSubjectException(
                "The JSONString subject was not processable - decode failed "
            );
        }

        // start walking the object
        foreach($jsonObj as $key => $property) {
            $schema->addProperty($key, $this->determineProperty($property, $key));
        }

        return $schema;
    }

    /**
     * @param mixed $property
     * @param string $name
     * @return \JSONSchema\Structure\Property
     */
    private function determineProperty($property, $name)
    {
        $baseUrl         = $this->getConfig('baseUrl');
        $requiredDefault = $this->getConfig('requiredDefault');
        $type            = StringMapper::map($property);

        $prop = new Property();
        $prop->setType($type)
             ->setName($name)
             ->setKey($name) // due to the limited content ability of the basic json string
             ->setRequired($requiredDefault);

        if($baseUrl === null) {
            $prop->setId($baseUrl . '/' . $name);
        }

        // since this is an object get the properties of the sub objects
        if($type === StringMapper::ARRAY_TYPE){
            foreach ($property as $data) {
                $prop->addItem(0, $this->determineItem($data, 0));
            }
        } elseif($type == StringMapper::OBJECT_TYPE) {
            foreach($property as $key => $newProperty) {
                $prop->addProperty($key, $this->determineProperty($newProperty, $key));
            }
        }

        return $prop;
    }

    /**
     * @param unknown $items
     * @param unknown $name
     * @return \JSONSchema\Structure\Item
     */
    private function determineItem($items, $name)
    {
        $baseUrl         = $this->getConfig('baseUrl');
        $requiredDefault = $this->getConfig('requiredDefault');
        $type            = StringMapper::map($items);

        $retItem = new Item();
        $retItem->setType($type);

        if($baseUrl === null) {
            $retItem->setId($baseUrl . '/' . $name);
        }


        if (StringMapper::map($items) === StringMapper::OBJECT_TYPE) {
            foreach (get_object_vars($items) as $key => $itemzz) {
                $retItem->addProperty($key, $this->determineProperty($itemzz, $key));
            }
        }

        return $retItem;
    }

    /**
     * @param string $name
     * @param mixed $item
     */
    private function stackItemFields($name, $item)
    {
        // for non-loopables
        if (is_array($item) === false && is_object($item) === false) {
            return;
        }

        foreach( $item as $key => $val) {
            $this->itemFields[$name][$key] = $val;
        }
    }
}
