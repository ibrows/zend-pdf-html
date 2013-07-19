<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class Ul extends BlockTag
{
    protected $newLine = true;

    /**
     * @return string
     */
    public function getName()
    {
        return 'ul';
    }
}