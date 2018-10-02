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
    private $config;
    /**
     * Sample constructor.
     *
     * @param \Nextpack\Nextpack\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     *
     * @return  string
     */
    public function sayHello($name)
    {
        $greeting = $this->config->get('greeting');
        var_dump($this->config->get("team_id"));
        return $greeting . ' ' . $name;
    }

}
