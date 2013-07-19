<?php

namespace Dominikzogg\ZendPdfHtml\Parser;

class Element
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var array
     */
    protected $tags;

    public function __construct($value, array $tags = array())
    {
        $this->value = $value;
        $this->tags = $tags;
    }
}