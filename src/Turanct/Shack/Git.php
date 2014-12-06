<?php

namespace Turanct\Shack;

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

