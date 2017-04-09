<?php

namespace App\Tests;

use App\ChatConnection;
use App\ChatServer;
use App\Factory\ChatConnectionFactory;
use App\Factory\SocketServerFactory;
use App\Value\PortNumber;
use React\EventLoop\Factory;

class ChatConnectionFactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function factoryReturnsConnection() {
    $chatConnectionFactory = new ChatConnectionFactory();
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    $loop = Factory::create();
    $socket = SocketServerFactory::create(new PortNumber(1337), $loop);
    $chatServer = new ChatServer($socket, $loop, new ChatConnectionFactory());
    $chatConnection = $chatConnectionFactory->create($connection, $chatServer);

    $this->assertInstanceOf(ChatConnection::class, $chatConnection);
    $socket->close();
  }
}
