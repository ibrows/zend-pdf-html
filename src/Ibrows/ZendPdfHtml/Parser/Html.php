<?php

namespace Ibrows\ZendPdfHtml\Parser;

use Ibrows\ZendPdfHtml\Parser\Element\ElementInterface;
use Ibrows\ZendPdfHtml\Parser\Element\DataElement;
use Ibrows\ZendPdfHtml\Parser\Element\ShortElement;
use Ibrows\ZendPdfHtml\Parser\Element\StartElement;
use Ibrows\ZendPdfHtml\Parser\Element\StopElement;
use Ibrows\ZendPdfHtml\Parser\Tag\AbstractTag;
use Ibrows\ZendPdfHtml\Parser\Tag\UnknownTag;

class Html
{
    protected $availableTags = array();

    public function registerTag(AbstractTag $tag)
    {
        $this->availableTags[strtolower($tag->getName())] = $tag;
    }

    /**
     * @param string $html
     * @return ElementInterface[]
     * @throws \ErrorException
     */
    public function parse($html)
    {
        $html = str_replace(array("\r\n", "\r", "\n"), ' ', $html);
        $buffer = '';
        $tagStack = array();
        $valueStack = array();
        $parts = array();
        $length = strlen($html);
        for($pointer = 0; $pointer < $length; $pointer++) {
            $sign = $html[$pointer];
            switch($sign) {
                case '<':
                    if($buffer) {
                        $parts[] = new DataElement($buffer, $tagStack);
                        $buffer = '';
                    }
                    break;
                case '>':
                    if($buffer) {
                        $buffer = strtolower($buffer);
                        // endtag
                        if(substr($buffer, 0, 1) == '/') {
                            $lastValue = array_pop($valueStack);
                            if($lastValue) {
                                $parts[] = new DataElement($lastValue, $tagStack);
                            }
                            $lastTag = array_pop($tagStack);
                            $openTagName = $lastTag->getName();
                            $closeTagName = substr($buffer, 1);
                            if($openTagName == $closeTagName) {
                                if(array_key_exists($closeTagName, $this->availableTags)) {
                                    $closeTag = clone $this->availableTags[$closeTagName];
                                } else {
                                    $closeTag = new UnknownTag($closeTagName);
                                }
                                $parts[] = new StopElement($closeTag, false);
                            } else {
                                throw new \ErrorException("Invalid Structure, open tag'{$openTagName}', close tag '{$closeTagName}'");
                            }
                        }
                        // shorttag
                        elseif(substr($buffer, -1) == '/') {
                            $buffer = trim(substr($buffer, 0, -1));
                            $tagParts = explode(' ', $buffer);
                            if(array_key_exists($tagParts[0], $this->availableTags)) {
                                $shortTag = clone $this->availableTags[$tagParts[0]];
                            } else {
                                $shortTag = new UnknownTag($tagParts[0]);
                            }
                            $parts[] = new ShortElement($shortTag, true);
                        }
                        // open tag
                        else {
                            $tagParts = explode(' ', $buffer);
                            if(array_key_exists($tagParts[0], $this->availableTags)) {
                                $openTag = clone $this->availableTags[$tagParts[0]];
                            } else {
                                $openTag = new UnknownTag($tagParts[0]);
                            }
                            $tagStack[] = $openTag;
                            $parts[] = new StartElement($openTag, true);
                        }
                        $buffer = '';
                    }
                    break;
                default:
                    $buffer .= $sign;
                    break;
            }
        }
        if($buffer) {
            $parts[] = new DataElement($buffer, array());
        }
        return $parts;
    }
}