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
     * @param string $key
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return boolean
     */
    public function getRequiredDefault()
    {
        return $this->requiredDefault;
    }

    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }
}