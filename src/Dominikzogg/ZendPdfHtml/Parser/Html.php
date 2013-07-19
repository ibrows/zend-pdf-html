<?php

namespace Dominikzogg\ZendPdfHtml\Parser;

use Dominikzogg\ZendPdfHtml\Parser\Tag\AbstractTag;
use Dominikzogg\ZendPdfHtml\Parser\Tag\UnknownTag;

class Html
{
    protected $availableTags = array();

    public function registerTag(AbstractTag $tag)
    {
        $this->availableTags[strtolower($tag->getName())] = $tag;
    }

    public function parse($html)
    {
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
                        $parts[] = new Element($buffer, $tagStack);
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
                                $parts[] = new Element($lastValue, $tagStack);
                            }
                            $lastTag = array_pop($tagStack);
                            $openTag = $lastTag->getName();
                            $closeTag = substr($buffer, 1);
                            if($openTag != $closeTag) {
                                throw new \ErrorException("Invalid Structure, open tag'{$openTag}', close tag '{$closeTag}'");
                            }
                        }
                        // ignore shorttag
                        elseif(substr($buffer, -1) == '/') {}
                        // open tag
                        else {
                            if(array_key_exists($buffer, $this->availableTags)) {
                                $tagStack[] = clone $this->availableTags[$buffer];
                            } else {
                                $tagStack[] = new UnknownTag($buffer);
                            }
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
            $parts[] = new Element($buffer, array());
        }
        return $parts;
    }
}