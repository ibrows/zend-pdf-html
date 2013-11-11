<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Element;

use Dominikzogg\ZendPdfHtml\Parser\Tag\AbstractTag;
use ZendPdf\Resource\Font\AbstractFont;

class DataElement implements ElementInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var AbstractTag[]
     */
    protected $tags;

    public function __construct($value, array $tags = array())
    {
        $this->value = $value;
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return AbstractTag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param AbstractFont $defaultFont
     * @return AbstractFont|null
     */
    public function getFont(AbstractFont $defaultFont)
    {
        $font = null;
        foreach($this->tags as $tag) {
            if(!is_null($tag->getFont())) {
                $font = $tag->getFont();
            }
        }
        return !is_null($font) ? $font : $defaultFont;
    }

    /**
     * @param float $defaultFontSize
     * @return float|null
     */
    public function getFontSize($defaultFontSize)
    {
        $fontSize = null;
        foreach($this->tags as $tag) {
            if(!is_null($tag->getFontSize())) {
                $fontSize = $tag->getFontSize();
            }
        }
        return !is_null($fontSize) ? $fontSize : $defaultFontSize;
    }
}