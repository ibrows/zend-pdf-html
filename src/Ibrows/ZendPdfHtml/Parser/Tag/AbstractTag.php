<?php

namespace Ibrows\ZendPdfHtml\Parser\Tag;

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

    /**
     * @return string|null
     */
    public function getListSign()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isBlockElement()
    {
        return false;
    }

    /**
     * @return int|null
     */
    public function marginTop()
    {
        return null;
    }

    /**
     * @return int|null
     */
    public function marginBottom()
    {
        return null;
    }

    /**
     * @return int|null
     */
    public function marginLeft()
    {
        return null;
    }
}