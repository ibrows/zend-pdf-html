<?php

namespace Ibrows\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class Strong extends AbstractTag
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'strong';
    }

    public function getFont()
    {
        return Font::fontWithName(Font::FONT_HELVETICA_BOLD);
    }
}