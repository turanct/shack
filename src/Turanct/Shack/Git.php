<?php

namespace Turanct\Shack;

/**
 * Get the current sha from a git repo
 */
final class Git implements Sha
{
    /**
     * Get the current sha hash
     *
     * @return string The current sha
     */
    public function get()
    {
        return exec('git rev-parse HEAD');
    }
}

