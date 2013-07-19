<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

use ZendPdf\Resource\Font\AbstractFont;

abstract class AbstractTag
{
    abstract public function getName();

    /**
     * @return AbstractFont|null
     */
    public function getFont()
    {
        return null;
    }

    /**
     * @return float|null
     */
    public function getFontSize()
    {
        return null;
    }
}