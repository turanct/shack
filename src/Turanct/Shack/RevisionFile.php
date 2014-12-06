<?php

namespace Turanct\Shack;

final class RevisionFile implements Sha
{
    private $dir;

    /**
     * Constructor
     *
     * @param string $dir The directory in which to look for REVISION file
     */
    public function __construct($dir)
    {
        $this->dir = (string) $dir;
    }

    /**
     * Get the current sha hash
     *
     * @return string The current sha
     */
    public function get()
    {
        return file_get_contents($this->dir . '/REVISION');
    }
}

