<?php
namespace Alekc\CrispThinking;


use Httpful\Http;
use Httpful\Request;

class Client
{
    /** @var Options */
    protected $option;

    /**
     * Client constructor.
     *
     * @param Options $option
     */
    public function __construct(Options $option)
    {
        $this->option = $option;
    }

    public function checkName($name, $policy = null)
    {
        if ($policy === null) $policy = $this->option->getDefaultPolicy();

        $params = $this->getDefaultParams();
        $params = array_merge($params, [
            "Id"     => "AccountNameCheck",
            "Name"   => $name,
            "Policy" => $this->option->getDefaultPolicy()
        ]);

        $uri      = $this->option->getEndPointUrl() . http_build_query($params);
        $response = $this->getHttpClient()
                         ->uri($uri)
                         ->send();
        $data = $response->body();
    }


    /***
     * Get's default parameters
     *
     * @return array
     * @throws \Exception
     */
    protected function getDefaultParams()
    {
        if (!$this->option->getApiKey()) throw new \Exception("ApiKey not set");
        $params = ["APIKey" => $this->option->getApiKey()];
        return $params;
    }

    protected function getHttpClient()
    {
        $request = Request::init(Http::GET)
                          ->expectsJson();
        return $request;
    }
}