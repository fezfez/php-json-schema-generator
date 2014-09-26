<?php
namespace JSONSchema\Structure;

abstract class AbstractStructure
{
    /**
     * @param array $data
     * @param array $array
     * @param string $name
     * @param string $id
     * @return multitype:
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