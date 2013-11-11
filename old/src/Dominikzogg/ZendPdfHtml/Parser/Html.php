<?php

namespace Dominikzogg\ZendPdfHtml\Parser;

use Dominikzogg\ZendPdfHtml\Parser\Element\ElementInterface;
use Dominikzogg\ZendPdfHtml\Parser\Element\DataElement;
use Dominikzogg\ZendPdfHtml\Parser\Element\ShortElement;
use Dominikzogg\ZendPdfHtml\Parser\Element\StartElement;
use Dominikzogg\ZendPdfHtml\Parser\Element\StopElement;
use Dominikzogg\ZendPdfHtml\Parser\Tag\AbstractTag;
use Dominikzogg\ZendPdfHtml\Parser\Tag\UnknownTag;

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
                            if(array_key_exists($buffer, $this->availableTags)) {
                                $shortTag = clone $this->availableTags[$buffer];
                            } else {
                                $shortTag = new UnknownTag($buffer);
                            }
                            $parts[] = new ShortElement($shortTag, true);
                        }
                        // open tag
                        else {
                            if(array_key_exists($buffer, $this->availableTags)) {
                                $openTag = clone $this->availableTags[$buffer];
                            } else {
                                $openTag = new UnknownTag($buffer);
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