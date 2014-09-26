<?php
namespace JSONSchema\Structure;

/**
 * Represents an Item or Element as defined
 * JSON Array Item
 *
 * @link http://tools.ietf.org/html/draft-zyp-json-schema-04#section-3.1
 * @link http://tools.ietf.org/html/rfc4627
 * @author steven
 *
 */
class Item extends AbstractStructure
{
    /**
     * Because the Item structure is of Array type we
     * need to pass in the parent ID differently
     * For now we can just hard code an :id field but later
     * it needs to have keys for various reasons
     *
     * @see JSONSchema\Structure.Property::toObject()
     */
    public function toObject($parentId = null)
    {
        $array = array(
            'id'                   => $this->getId(),
            'type'                 => $this->getType(),
            'title'                => $this->getTitle(),
            'description'          => $this->getDescription(),
            'name'                 => $this->getName(),
            'additionalProperties' => $this->hasAdditionalProperties()
        );

        $array = $this->hydrateCollection($this->getProperties(), $array, 'properties');

        $array['required'] = $this->getRequired();

        return (object) $array;
    }
}
