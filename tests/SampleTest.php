<?php

namespace Retrofico\Retrofico\Tests;

use Retrofico\Retrofico\Client;
use Retrofico\Retrofico\Config;

/**
 * Class SampleTest
 *
 * @category Test
 * @package  Retrofico\Retrofico\Tests
 */
class SampleTest extends TestCase
{

    public function testSayHello()
    {
        $config = new Config("lorem", "ipsum");
        $client = new Client($config);

        $name = 'retrofico';

        $result = $client->get("surveys");
        var_dump($result);

        /*$expected = $config->get('greeting') . ' ' . $name;

    $this->assertEquals($result, $expected);*/

    }

}
