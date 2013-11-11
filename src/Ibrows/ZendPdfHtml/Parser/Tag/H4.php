<?php

namespace Ibrows\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class H4 extends BlockTag
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'h4';
    }

    public function getFont()
    {
        return Font::fontWithName(Font::FONT_HELVETICA_BOLD);
    }

    /**
     * @return int
     */
    public function marginBottom()
    {
        return 5;
    }
}