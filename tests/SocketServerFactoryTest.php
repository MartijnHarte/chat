<?php

namespace App\Tests;

use App\Factory\SocketServerFactory;
use App\Value\PortNumber;
use React\EventLoop\Factory;
use React\Socket\ServerInterface;

class SocketServerFactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function factoryReturnsSocketServer() {
    $socket = SocketServerFactory::create(new PortNumber(), Factory::create());

    $this->assertInstanceOf(ServerInterface::class, $socket);
  }
}
