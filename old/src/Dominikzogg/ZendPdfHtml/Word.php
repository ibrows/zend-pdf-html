<?php

namespace Dominikzogg\ZendPdfHtml;

use ZendPdf\Resource\Font\AbstractFont;

class Word
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $x;

    /**
     * @var int
     */
    protected $y;

    /**
     * @var AbstractFont
     */
    protected $font;

    /**
     * @var float
     */
    protected $fontSize;

    public function __construct($text, $x, $y, AbstractFont $font, $fontSize)
    {
        $this->text = $text;
        $this->x = $x;
        $this->y = $y;
        $this->font = $font;
        $this->fontSize = $fontSize;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return AbstractFont
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @return float
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }
}