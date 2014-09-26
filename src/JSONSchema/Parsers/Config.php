<?php
namespace JSONSchema\Parsers;

class Config
{
    /**
     * @var string
     */
    private $baseUrl = null;
    /**
     * @var bool
     */
    private $requiredDefault = false;
    /**
     * @var bool
     */
    private $additionalProperties = false;

    /**
     * @param string $baseUrl
     * @return \JSONSchema\Parsers\Config
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param boolean $requiredDefault
     * @return \JSONSchema\Parsers\Config
     */
    public function setRequiredDefault($requiredDefault)
    {
        $this->requiredDefault = (bool) $requiredDefault;

        return $this;
    }

    /**
     * @param boolean $additionalProperties
     * @return \JSONSchema\Parsers\Config
     */
    public function setAdditionalProperties($additionalProperties)
    {
        $this->additionalProperties = (bool) $additionalProperties;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return boolean
     */
    public function isRequiredDefault()
    {
        return $this->requiredDefault;
    }

    /**
     * @return boolean
     */
    public function hasAdditionalProperties()
    {
        return $this->additionalProperties;
    }
}
