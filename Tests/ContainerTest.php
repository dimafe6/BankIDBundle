<?php

namespace Dimafe6\BankIDBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContainerTest extends KernelTestCase
{
    public static function setUpBeforeClass()
    {
        self::bootKernel();
    }

    public function testContainer()
    {
        $this->assertTrue(self::$kernel->getContainer()->has('dimafe6.bankid'));
    }
}
