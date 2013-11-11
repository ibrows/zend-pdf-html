<?php

namespace Ibrows\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

abstract class BlockTag extends AbstractTag
{
    /**
     * @return bool
     */
    public function isBlockElement()
    {
        return true;
    }
}