<?php

namespace Turanct\Shack;

final class RevisionFile implements Sha
{
    /**
     * The path to the file in which the sha is stored
     */
    private $filePath;

    /**
     * Constructor
     *
     * @param string $filePath The path to the file in which the sha is stored
     */
    public function __construct($filePath)
    {
        $this->filePath = (string) $filePath;
    }

    /**
     * Get the current sha hash
     *
     * @return string The current sha
     */
    public function get()
    {
        return @file_get_contents($this->filePath);
    }
}

