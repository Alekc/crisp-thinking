<?php
namespace Alekc\CrispThinking\Request\Traits;


trait ContentTypeTrait
{
    protected $contentType;

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     *
     * @return static Instance
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }


}