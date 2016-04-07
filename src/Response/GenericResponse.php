<?php
namespace Alekc\CrispThinking\Response;

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07/04/2016
 * Time: 12:41
 */
class GenericResponse
{
    /** @var  \Httpful\Response */
    protected $httpResponse;

    protected $responseCode = 0;

    protected $originalData;

    protected $filtered = false;

    /**
     * GenericResponse constructor.
     */
    public function __construct(\Httpful\Response $httpResponse)
    {
        $this->httpResponse = $httpResponse;
        $this->responseCode = $httpResponse->code;
        $this->originalData = $httpResponse->body;
    }

    /**
     * Check if request has been successful.
     *
     * @return bool
     */
    public function isRequestOk(){
        return $this->responseCode == 200;
    }

    /**
     * @return \Httpful\Response
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return array|object|string
     */
    public function getOriginalData()
    {
        return $this->originalData;
    }

    /**
     * @return boolean
     */
    public function isFiltered()
    {
        return $this->filtered;
    }
}