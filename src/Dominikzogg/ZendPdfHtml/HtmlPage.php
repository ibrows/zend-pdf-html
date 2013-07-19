<?php

namespace Dominikzogg\ZendPdfHtml;

use Dominikzogg\ZendPdfHtml\Parser\Html;
use ZendPdf\Page;

class HtmlPage
{
    /**
     * @var Page
     */
    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function drawHtml($html, $x, $y, $w = 0)
    {
        $parser = new Html();
        $parts = $parser->parse($html);
        print_r($parts);
    }
}