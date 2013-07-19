<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class Li extends BlockTag
{
    protected $newLine = true;

    /**
     * @return string
     */
    public function getName()
    {
        return 'li';
    }
}