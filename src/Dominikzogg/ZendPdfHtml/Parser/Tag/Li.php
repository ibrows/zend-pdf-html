<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class Li extends BlockTag
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'li';
    }
}