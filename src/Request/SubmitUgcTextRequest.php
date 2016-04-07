<?php
namespace Alekc\CrispThinking\Request;


use Alekc\CrispThinking\Crisp;
use Alekc\CrispThinking\Request;
use Alekc\CrispThinking\Request\Traits\ContentTypeTrait;
use Alekc\CrispThinking\Response\SubmitUgcTextResponse;

class SubmitUgcTextRequest extends GenericRequest
{
    use ContentTypeTrait;

    const CALL_PATH = "/Rmf/v2/SubmitUgcText";

    protected $parentId             = null;
    protected $author               = "";
    protected $authorDisplayName    = "";
    protected $recipient            = "WORLD";
    protected $recipientDisplayName = "";
    protected $text                 = "";
    protected $profile              = true;
    protected $policy               = "";
    protected $room                 = "";


    public function send()
    {
        $params  = $this->prepareParams();
        $options = Crisp::getOptions();
        $url     = $options->getCrispEndPoint() . static::CALL_PATH;

        $httpResponse = \Httpful\Request::post($url)
                                        ->body(json_encode($params))
                                        ->send();

        $response = new SubmitUgcTextResponse($httpResponse);
        return $response;
    }

    protected function prepareParams()
    {
        $params = $this->getDefaultParams();

        //set parameters for the call
        $params["ContentType"]          = $this->getContentType();
        $params["ContentId"]            = $this->getContentId();
        $params["ParentId"]             = $this->parentId;
        $params["Author"]               = $this->author;
        $params["AuthorDisplayName"]    = $this->authorDisplayName;
        $params["Recipient"]            = $this->recipient;
        $params["RecipientDisplayName"] = $this->recipientDisplayName;
        $params["Text"]                 = $this->text;
        $params["Profile"]              = $this->profile;
        $params["Policy"]               = $this->policy;
        $params["Room"]                 = $this->room;

        //clean params.
        $params = $this->cleanParams($params);

        //add default values if needed
        $this->addDefaultParamValues("ApiKey", $params)
             ->addDefaultParamValues("ContentType", $params);

        //add contentId if needed
        if (!$this->contentId) $params["ContentId"] = $this->generateContentId();

        return $params;
    }

    /**
     * @param null $parentId
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @param string $author
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @param string $authorDisplayName
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setAuthorDisplayName($authorDisplayName)
    {
        $this->authorDisplayName = $authorDisplayName;
        return $this;
    }

    /**
     * @param string $recipient
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @param string $recipientDisplayName
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setRecipientDisplayName($recipientDisplayName)
    {
        $this->recipientDisplayName = $recipientDisplayName;
        return $this;
    }

    /**
     * @param string $text
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param boolean $profile
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @param string $policy
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setPolicy($policy)
    {
        $this->policy = $policy;
        return $this;
    }

    /**
     * @param string $room
     *
     * @return SubmitUgcTextRequest Instance
     */
    public function setRoom($room)
    {
        $this->room = $room;
        return $this;
    }
}