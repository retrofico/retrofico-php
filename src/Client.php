<?php

namespace Retrofico\Retrofico;

/**
 * Minimalist retrofi.co API wrapper
 * This wrapper: https://github.com/retrofico/retrofico-php
 *
 * @author  Remy Vanherweghem <remy@retrofi.co>
 */
class Client
{
    protected $config;

    /**
     * Sample constructor.
     *
     * @param \Nextpack\Nextpack\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

}
