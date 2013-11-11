<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class P extends BlockTag
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'p';
    }

    /**
     * @return int
     */
    public function marginBottom()
    {
        return 10;
    }
}