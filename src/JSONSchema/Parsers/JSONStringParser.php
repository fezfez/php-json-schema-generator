<?php
namespace JSONSchema\Parsers;

use JSONSchema\Structure\Property;
use JSONSchema\Structure\Item;
use JSONSchema\Structure\Schema;
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
        if(null === $jsonObj = json_decode($subject)) {
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
        $type            = PropertyTypeMapper::map($property);

        $prop = new Property();
        $prop->setType($type)
             ->setName($name)
             ->setKey($name) // due to the limited content ability of the basic json string
             ->setRequired($requiredDefault);

        if ($baseUrl !== null) {
            $prop->setId($baseUrl . '/' . $name);
        }

        return $this->determineChildProperty($type, $property, $prop);
    }

    /**
     * @param string $type
     * @param mixed $property
     * @param Property $prop
     * @return Ambiguous
     */
    private function determineChildProperty($type, $property, Property $prop)
    {
        $types = array(
            PropertyTypeMapper::ARRAY_TYPE  => 'Item',
            PropertyTypeMapper::OBJECT_TYPE => 'Property'
        );

        if (false === $method = array_keys($types, $type)) {
            foreach ($property as $key => $newProperty) {
                $addMethod = 'add' . $method;
                $dertermineMethod = 'determine' . $method;
                $prop->$addMethod($key, $this->$dertermineMethod($newProperty, $key));
            }
        }

        return $prop;
    }

    /**
     * @param mixed $items
     * @param string $name
     * @return \JSONSchema\Structure\Item
     */
    private function determineItem($items, $name)
    {
        $baseUrl         = $this->getConfig('baseUrl');
        $requiredDefault = $this->getConfig('requiredDefault');
        $type            = PropertyTypeMapper::map($items);

        $retItem = new Item();
        $retItem->setType($type);

        if ($baseUrl !== null) {
            $retItem->setId($baseUrl . '/' . $name);
        }

        return $this->determineChildItem($items, $retItem);
    }

    /**
     * @param mixed $property
     * @param Item $item
     * @return Item
     */
    private function determineChildItem($property, Item $item)
    {
        if (PropertyTypeMapper::map($property) === PropertyTypeMapper::OBJECT_TYPE) {
            foreach (get_object_vars($property) as $key => $itemzz) {
                $item->addProperty($key, $this->determineProperty($itemzz, $key));
            }
        }

        return $item;
    }
}
