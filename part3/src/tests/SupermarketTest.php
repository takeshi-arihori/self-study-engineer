<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/Supermarket.php');

class SupermarketTest extends TestCase
{
    public function testCalc()
    {
        $this->assertEquals(1298, calculate('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10]));
    }
}
