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

    /**
     * @return int|null
     */
    public function marginLeft()
    {
        return 10;
    }
}