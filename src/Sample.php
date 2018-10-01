<?php

namespace Retrofico\Retrofico;

/**
 * Class Sample
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Sample
{

    /**
     * @var  \Retrofico\Retrofico\Config
     */
    private $config;

    /**
     * Sample constructor.
     *
     * @param \Retrofico\Retrofico\Config $config
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

        return $greeting . ' ' . $name;
    }

}
