<?php

namespace Turanct\Shack;

final class String implements Sha
{
    /**
     * @var string The sha string
     */
    private $string;

    /**
     * Constructor
     *
     * @param string $string The sha string
     */
    public function __construct($string)
    {
        $this->string = (string) $string;
    }

    /**
     * Get the current sha hash
     *
     * @return string The current sha
     */
    public function get()
    {
        return $this->string;
    }
}

