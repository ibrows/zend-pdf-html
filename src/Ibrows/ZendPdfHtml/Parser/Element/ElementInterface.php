<?php

namespace Ibrows\ZendPdfHtml\Parser\Element;

use ZendPdf\Resource\Font\AbstractFont;

interface ElementInterface
{
    /**
     * @param AbstractFont $defaultFont
     * @return AbstractFont|null
     */
    public function getFont(AbstractFont $defaultFont);

    /**
     * @param float $defaultFontSize
     * @return float|null
     */
    public function getFontSize($defaultFontSize);
}