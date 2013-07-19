<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Element;

use Dominikzogg\ZendPdfHtml\Parser\Tag\AbstractTag;

class ControllElement implements ElementInterface
{
    protected $tag;

    public function __construct(AbstractTag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return bool
     */
    public function isBlockElement()
    {
        return $this->tag->isBlockElement();
    }

    /**
     * @return int|null
     */
    public function marginTop()
    {
        return $this->tag->marginTop();
    }

    /**
     * @return int|null
     */
    public function marginBottom()
    {
        return $this->tag->marginBottom();
    }

    /**
     * @return int|null
     */
    public function marginLeft()
    {
        return $this->tag->marginLeft();
    }
}