<?php
namespace Alekc\CrispThinking\Request;


use Alekc\CrispThinking\Crisp;
use Alekc\CrispThinking\Options;
use Alekc\CrispThinking\Request\Traits\ApiKeyTrait;

class GenericRequest
{
    use ApiKeyTrait;

    const CALL_PATH = "";

    protected $contentId;

    /** @var  Options */
    protected $options;

    /**
     * GenericRequest constructor.
     */
    public function __construct()
    {
        $this->options = Crisp::getOptions();
    }


    protected function getDefaultParams(){
        return [
            "ApiKey" => $this->getApiKey()
        ];
    }

    public function send()
    {

    }

    protected function addDefaultParamValues($key, &$params)
    {
        if (!is_array($params)) throw new \InvalidArgumentException("Params should be an array");

        //if the option is already set, then skip it.
        if (isset($params[$key]) && !empty($params[$key])) return $this;

        $params[$key] = $this->options->getParamByKey($key);

        return $this;
    }

    /**
     * Generate Random Content Id
     *
     * @return string
     */
    protected function generateContentId()
    {
        return time() . mt_rand(1, 10000000);
    }

    /**
     * Remove empty fields from params.
     *
     * @param array $params
     *
     * @return array
     */
    protected function cleanParams($params)
    {
        if (!is_array($params)) throw new \InvalidArgumentException("Params should be an array");

        foreach ($params as $key => $val) {
            if (empty($val)) unset($params[$key]);
        }
        return $params;
    }

    /**
     * @return mixed
     */
    protected function getContentId()
    {
        return $this->contentId;
    }

    /**
     * @param mixed $contentId
     *
     * @return GenericRequest Instance
     */
    protected function setContentId($contentId)
    {
        $this->contentId = $contentId;
        return $this;
    }


}