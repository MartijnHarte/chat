<?php

namespace App\Tests;

use App\Factory\SocketServerFactory;
use App\Tests\TestDoubles\ChatServerSpy;
use App\Value\PortNumber;
use PHPUnit_Framework_TestCase;
use React\EventLoop\Factory;

class ChatServerTest extends PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function canEstablishConnectionToChatServer() {
    $loop = Factory::create();
    $socket = SocketServerFactory::create(new PortNumber(1337), $loop);
    $chatServer = new ChatServerSpy($socket, $loop);

    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    $socket->emit('connection', array($connection));

    $this->assertTrue($chatServer->establishedConnection());
  }

}
