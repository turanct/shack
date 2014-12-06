<?php

namespace Turanct\Shack;

/**
 * Get the current sha from a REVISION file
 *
 * The filepath can be specified as a constructor parameter
 */
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

