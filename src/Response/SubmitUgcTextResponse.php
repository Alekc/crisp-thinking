<?php
namespace Alekc\CrispThinking\Response;
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07/04/2016
 * Time: 13:11
 */
class SubmitUgcTextResponse extends GenericResponse
{
    protected $filteredText = "";

    public function __construct(\Httpful\Response $httpResponse)
    {
        parent::__construct($httpResponse);

        //if the request is not good, then return.
        if ($this->responseCode != 200) return;

        //see if it's filtered
        $this->filtered     = $this->originalData->Result == 2 || $this->originalData->Result == 1;
        $this->filteredText = $this->originalData->FilteredText;
    }

    /**
     * @return string
     */
    public function getFilteredText()
    {
        return $this->filteredText;
    }
}