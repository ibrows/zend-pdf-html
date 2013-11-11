<?php

namespace Ibrows\ZendPdfHtml\Parser\Tag;

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
     * @return int
     */
    public function marginLeft()
    {
        return 10;
    }

    /**
     * @return string
     */
    public function getListSign()
    {
        return '-';
    }
}