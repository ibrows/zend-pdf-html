<?php

namespace Ibrows\ZendPdfHtml\Parser\Tag;

use ZendPdf\Font;

class Br extends BlockTag
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'br';
    }
}