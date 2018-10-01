<?php

namespace Retrofico\Retrofico\Tests;

use Retrofico\Retrofico\Config;
use Retrofico\Retrofico\Sample;

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
        $config = new Config();
        $sample = new Sample($config);

        $name = 'retrofico';

        $result = $sample->sayHello($name);

        $expected = $config->get('greeting') . ' ' . $name;

        $this->assertEquals($result, $expected);

    }

}
