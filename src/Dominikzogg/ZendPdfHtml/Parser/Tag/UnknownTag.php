<?php

namespace Dominikzogg\ZendPdfHtml\Parser\Tag;

class UnknownTag extends AbstractTag
{
    /**
     * @var string
     */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string) $this->name;
    }
}