<?php
namespace Alekc\CrispThinking;

class Options
{
    protected $server;
    protected $port;
    protected $timeout;
    protected $attempts;
    protected $senderPrefix = "";

    protected $defaultPolicy = "";
    protected $apiKey        = "";

    /**
     * Creates new options setting server ip and port to which you want to connect
     *
     * @param $server
     * @param $port
     *
     * @return static
     */
    public static function create($server, $port)
    {
        $self         = new static();
        $self->server = $server;
        $self->port   = $port;

        return $self;
    }

    public function getEndPointUrl(){
        return "https://{$this->getServer()}:{$this->getPort()}/";
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     *
     * @return Options Instance
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     *
     * @return Options Instance
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @param mixed $attempts
     *
     * @return Options Instance
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     *
     * @return Options Instance
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderPrefix()
    {
        return $this->senderPrefix;
    }

    /**
     * @param string $senderPrefix
     *
     * @return Options Instance
     */
    public function setSenderPrefix($senderPrefix)
    {
        $this->senderPrefix = $senderPrefix;
        return $this;
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
    public function getDefaultPolicy()
    {
        return $this->defaultPolicy;
    }

    /**
     * @param string $defaultPolicy
     *
     * @return Options Instance
     */
    public function setDefaultPolicy($defaultPolicy)
    {
        $this->defaultPolicy = $defaultPolicy;
        return $this;
    }
}