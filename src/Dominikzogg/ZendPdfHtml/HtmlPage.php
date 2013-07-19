<?php

namespace Dominikzogg\ZendPdfHtml;

use Dominikzogg\ZendPdfHtml\Parser\Element\ControllElement;
use Dominikzogg\ZendPdfHtml\Parser\Element\DataElement;
use Dominikzogg\ZendPdfHtml\Parser\Element\StartElement;
use Dominikzogg\ZendPdfHtml\Parser\Element\StopElement;
use Dominikzogg\ZendPdfHtml\Parser\Html;
use ZendPdf\Page;
use ZendPdf\Font;
use ZendPdf\Resource\Font\AbstractFont;

class HtmlPage
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * @var Html
     */
    protected $parser;

    public function __construct(Page $page)
    {
        $this->setPage($page);
    }

    /**
     * @param Page $page
     * @return HtmlPage
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return Page
     */
    protected function getPage()
    {
        return $this->page;
    }

    /**
     * @param Html $parser
     * @return HtmlPage
     */
    public function setParser(Html $parser)
    {
        $this->parser = $parser;
        return $this;
    }

    /**
     * @return Html
     */
    public function getParser()
    {
        if(is_null($this->parser)) {
            $this->parser = new Html();
        }

        return $this->parser;
    }

    public function drawHtml($html, $x1, $y1, $x2 = null, $y2 = null)
    {
        if(is_null($x2)) {
            $x2 = $this->getPage()->getWidth() - $x1;
        }

        if(is_null($y2)) {
            $y2 = $this->getPage()->getWidth() - $y1;
        }

        $x = $x1;
        $y = $y1;

        if(is_null($this->getPage()->getFont())) {
            $this->getPage()->setFont(Font::fontWithName(Font::FONT_HELVETICA), 10);
        }

        $defaultFont = $this->getPage()->getFont();
        $defaultfontSize = $this->getPage()->getFontSize();
        $maxFontSize = $defaultfontSize;
        $words = array();
        $elements = $this->getParser()->parse($html);
        foreach($elements as $element) {
            if($element instanceof DataElement) {
                $font = $element->getFont($defaultFont);
                $fontSize = $element->getFontSize($defaultfontSize);
                $maxFontSize = $fontSize > $maxFontSize ? $fontSize : $maxFontSize;
                $rawWords = explode(' ', $element->getValue());
                foreach($rawWords as $rawWord) {
                    $rawWord .= $rawWord ? ' ' : '';
                    $wordWith = self::widthForStringUsingFontSize($rawWord, $font, $fontSize);
                    if($x + $wordWith > $x2) {
                        $x = $x1;
                        if($x1 > $x2) {
                            $y += $maxFontSize * 1.3;
                        } else {
                            $y -= $maxFontSize * 1.3;
                        }
                        $maxFontSize = $fontSize;
                    }
                    $words[] = new Word($rawWord, $x, $y, $font, $fontSize);
                    $x += $wordWith;
                }
            } elseif($element instanceof ControllElement) {
                if($element->isBlockElement()) {
                    if($x != $x1) {
                        $x = $x1;
                        if($x1 > $x2) {
                            $y += $maxFontSize * 1.3;
                        } else {
                            $y -= $maxFontSize * 1.3;
                        }
                        $maxFontSize = $defaultfontSize;
                    }
                    if($element instanceof StartElement && !is_null($element->marginTop())) {
                        if($x1 > $x2) {
                            $y += $element->marginTop();
                        } else {
                            $y -= $element->marginTop();
                        }
                    }
                    if($element instanceof StopElement && !is_null($element->marginBottom())) {
                        if($x1 > $x2) {
                            $y += $element->marginBottom();
                        } else {
                            $y -= $element->marginBottom();
                        }
                    }
                }
            }
        }

        foreach($words as $word)
        {
            /** @var Word $word */
            $this->getPage()->setFont($word->getFont(), $word->getFontSize());
            $this->getPage()->drawText($word->getText(), $word->getX(), $word->getY());
        }
    }

    protected static function widthForStringUsingFontSize($string, AbstractFont $font, $fontSize)
    {
        $drawingString = iconv('UTF-8', 'UTF-16BE//IGNORE', $string);
        $characters = array();
        for ($i = 0; $i < strlen($drawingString); $i++) {
            $characters[] = (ord($drawingString[$i++]) << 8 ) | ord($drawingString[$i]);
        }
        $glyphs = $font->glyphNumbersForCharacters($characters);
        $widths = $font->widthsForGlyphs($glyphs);
        $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
        return $stringWidth;
    }
}