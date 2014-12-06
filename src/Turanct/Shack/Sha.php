<?php

namespace Turanct\Shack;

/**
 * Sha interface
 *
 * Every Shack instance will an Sha implementation as input
 */
interface Sha
{
    /**
     * Get the current sha hash
     *
     * @return string The current sha
     */
    public function get();
}
