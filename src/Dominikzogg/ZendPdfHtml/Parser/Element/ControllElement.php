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

    public function isBlockElement()
    {
        return $this->tag->isBlockElement();
    }
}