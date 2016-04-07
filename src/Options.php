<?php
namespace Alekc\CrispThinking;

class Options
{
    const CRISP_LIVE_END_POINT    = "http://stage1.dc1.rmf.crispthinking.com";
    const CRISP_STAGING_END_POINT = "http://live1.dc1.rmf.crispthinking.com";


    /**
     * @var Options  reference to singleton instance of this class
     */
    protected static $instance;

    protected $apiKey             = "";
    protected $defaultPolicy      = "";
    protected $defaultContentType = "";
    protected $isLive             = true;

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
            static::$instance->reset();
        }

        return static::$instance;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->apiKey             = "";
        $this->defaultContentType = "";
        $this->defaultPolicy      = "";
        $this->isLive             = true;
        return $this;
    }


    /**
     * @param $key
     *
     * @return string
     */
    public function getParamByKey($key)
    {
        switch ($key) {
            case "ApiKey":
                return $this->getApiKey();
            case "ContentType":
                return $this->getDefaultContentType();
            case "Policy":
                return $this->getDefaultPolicy();
            default:
                throw new \InvalidArgumentException("Unknown key");
        }
    }

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
     * @return Options Instance
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultContentType()
    {
        return $this->defaultContentType;
    }

    /**
     * @param string $defaultContentType
     *
     * @return Options
     */
    public function setDefaultContentType($defaultContentType)
    {
        $this->defaultContentType = $defaultContentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultPolicy()
    {
        return $this->defaultPolicy;
    }

    /**
     * @param string $defaultPolicy
     *
     * @return Options
     */
    public function setDefaultPolicy($defaultPolicy)
    {
        $this->defaultPolicy = $defaultPolicy;
        return $this;
    }

    /**
     * @return string
     */
    public function getCrispEndPoint()
    {
        if (!$this->isLive) {
            return self::CRISP_STAGING_END_POINT;
        }
        return self::CRISP_LIVE_END_POINT;
    }

    /**
     * @param string $crispEndPoint
     *
     * @return Options Instance
     */
    public function setCrispEndPoint($crispEndPoint)
    {
        $this->crispEndPoint = $crispEndPoint;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsLive()
    {
        return $this->isLive;
    }

    /**
     * @param boolean $isLive
     *
     * @return Options Instance
     */
    public function setIsLive($isLive)
    {
        $this->isLive = $isLive;
        return $this;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}