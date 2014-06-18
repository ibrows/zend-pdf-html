<?php

namespace Ibrows\ZendPdfHtml;

use Ibrows\ZendPdfHtml\Parser\Element\ControllElement;
use Ibrows\ZendPdfHtml\Parser\Element\DataElement;
use Ibrows\ZendPdfHtml\Parser\Element\StartElement;
use Ibrows\ZendPdfHtml\Parser\Element\StopElement;
use Ibrows\ZendPdfHtml\Parser\Html;
use ZendPdf\Page;
use ZendPdf\Font;
use ZendPdf\Resource\Font\AbstractFont;

class HtmlDrawer
{
    /**
     * @var Html
     */
    protected $parser;

    /**
     * @param Html $parser
     * @return $this
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

    public function drawHtml(Page $page, $html, $x1, $y1, $x2 = null, $y2 = null, $lineHeight = 1.3, $charEncoding = '')
    {
        if(is_null($x2)) {
            $x2 = $page->getWidth() - $x1;
        }

        if(is_null($y2)) {
            $y2 = $page->getHeight() - $y1;
        }

        $x = $x1;
        $y = $y1;

        if(is_null($page->getFont())) {
            $page->setFont(Font::fontWithName(Font::FONT_HELVETICA), 10);
        }

        $defaultFont = $page->getFont();
        $defaultfontSize = $page->getFontSize();
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
                    $wordWith = $this->widthForStringUsingFontSize($rawWord, $font, $fontSize);
                    if($x + $wordWith > $x2) {
                        $x = $x1;
                        if($y1 < $y2) {
                            $y += $maxFontSize * $lineHeight;
                        } else {
                            $y -= $maxFontSize * $lineHeight;
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
                        if($y1 < $y2) {
                            $y += $maxFontSize * $lineHeight;
                        } else {
                            $y -= $maxFontSize * $lineHeight;
                        }
                        $maxFontSize = $defaultfontSize;
                    }
                    if($element instanceof StartElement) {
                        if(!is_null($element->marginTop())) {
                            if($y1 < $y2) {
                                $y += $element->marginTop();
                            } else {
                                $y -= $element->marginTop();
                            }
                        }
                        if(!is_null($element->marginLeft())) {
                            if(!is_null($element->getListSign())) {
                                $words[] = new Word($element->getListSign(), $x, $y, $element->getFont($defaultFont), $element->getFontSize($defaultfontSize));
                            }
                            $x1 += $element->marginLeft();
                            $x = $x1;
                        }
                    }
                    if($element instanceof StopElement) {
                        if(!is_null($element->marginBottom())) {
                            if($y1 < $y2) {
                                $y += $element->marginBottom();
                            } else {
                                $y -= $element->marginBottom();
                            }
                        }
                        if(!is_null($element->marginLeft())) {
                            $x1 -= $element->marginLeft();
                            $x = $x1;
                        }
                    }
                }
            }
        }

        foreach($words as $word) {
            /** @var Word $word */
            $page->setFont($word->getFont(), $word->getFontSize());
            $page->drawText($word->getText(), $word->getX(), $word->getY(), $charEncoding);
        }

        return array($x, $y);
    }

    public function widthForStringUsingFontSize($string, AbstractFont $font, $fontSize)
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