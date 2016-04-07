<?php
namespace Alekc\CrispThinking\Request\Traits;


trait ApiKeyTrait
{
    protected $apiKey = "";

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return static Instance
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }
}