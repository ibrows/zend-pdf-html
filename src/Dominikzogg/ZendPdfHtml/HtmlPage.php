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

    /**
     * @var Html
     */
    protected $parser;

    public function __construct(Page $page)
    {
        $this->setPage($page);
    }

    /**
     * @param Page $page
     * @return HtmlPage
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return Page
     */
    protected function getPage()
    {
        return $this->page;
    }

    /**
     * @param Html $parser
     * @return HtmlPage
     */
    public function setParser(Html $parser)
    {
        $this->parser = $parser;
        return $this;
    }

    /**
     * @return Html
     */
    protected function getParser()
    {
        if(is_null($this->parser)) {
            $this->parser = new Html();
        }

        return $this->parser;
    }

    public function drawHtml($html, $x, $y, $w = 0)
    {
        $elements = $this->getParser()->parse($html);
        print_r($elements);
    }
}