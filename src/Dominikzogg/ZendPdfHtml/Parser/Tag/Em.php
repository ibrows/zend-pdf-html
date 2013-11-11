<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class Em extends AbstractTag
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'em';
    }

    public function getFont()
    {
        // Font->isBold();
    }
}