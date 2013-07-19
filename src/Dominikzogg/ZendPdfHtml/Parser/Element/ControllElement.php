<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Element;

use Dominikzogg\ZendPdfHtml\Parser\Tag\AbstractTag;
use ZendPdf\Resource\Font\AbstractFont;

class ControllElement implements ElementInterface
{
    protected $tag;

    public function __construct(AbstractTag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param AbstractFont $defaultFont
     * @return AbstractFont|null
     */
    public function getFont(AbstractFont $defaultFont)
    {
        return !is_null($this->tag->getFont()) ? $this->tag->getFont() : $defaultFont;
    }

    /**
     * @param float $defaultFontSize
     * @return float|null
     */
    public function getFontSize($defaultFontSize)
    {
        return !is_null($this->tag->getFontSize()) ? $this->tag->getFontSize() : $defaultFontSize;
    }

    public function getListSign()
    {
        return $this->tag->getListSign();
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