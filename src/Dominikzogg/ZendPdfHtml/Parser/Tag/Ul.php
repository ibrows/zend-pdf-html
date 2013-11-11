<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class Ul extends BlockTag
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'ul';
    }

    /**
     * @return int
     */
    public function marginBottom()
    {
        return 10;
    }
}