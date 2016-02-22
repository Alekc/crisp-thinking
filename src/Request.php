<?php


namespace Alekc\CrispThinking;


class Request
{
    /** @var  \DateTime */
    protected $sentAt;

    protected $sender;
    protected $receiver;
    protected $event;
    protected $eventData;
    protected $level;

    protected $id;
    protected $method;
    protected $params;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->sentAt = new \DateTime();
    }

    /**
     * Creates new instance of Request. Good for chaining.
     *
     * @return static
     */
    public static function create(){
        $ins = new static();
        return $ins;
    }

    /**
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * @param \DateTime $sentAt
     *
     * @return Request Instance
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     *
     * @return Request Instance
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     *
     * @return Request Instance
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     *
     * @return Request Instance
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventData()
    {
        return $this->eventData;
    }

    /**
     * @param mixed $eventData
     *
     * @return Request Instance
     */
    public function setEventData($eventData)
    {
        $this->eventData = $eventData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     *
     * @return Request Instance
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Request Instance
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     *
     * @return Request Instance
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     *
     * @return Request Instance
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

}