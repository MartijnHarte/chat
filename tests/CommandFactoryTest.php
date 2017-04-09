<?php

namespace App\Tests;

use App\ChatConnectionInterface;
use App\ChatServer;
use App\Factory\ChatConnectionFactory;
use App\Factory\CommandFactory;
use App\Factory\SocketServerFactory;
use App\Value\PortNumber;
use React\EventLoop\Factory;
use React\Socket\ServerInterface;

class CommandFactoryTest extends \PHPUnit_Framework_TestCase {
  /** @var ServerInterface */
  private $socket;
  /** @var ChatConnectionInterface */
  private $chatConnection;

  public function setUp() {
    $chatConnectionFactory = new ChatConnectionFactory();
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    $loop = Factory::create();
    $this->socket = SocketServerFactory::create(new PortNumber(1337), $loop);
    $chatServer = new ChatServer($this->socket, $loop, new ChatConnectionFactory());
    $this->chatConnection = $chatConnectionFactory->create($connection, $chatServer);
  }

  /**
   * @test
   * @expectedException \App\Exception\UnknownCommandException
   * @expectedExceptionMessage The command "/unknown" is not known to the system.
   */
  public function givenUnknownCommandThrowsException() {
    $this->socket->close();
    CommandFactory::create($this->chatConnection, '/unknown');
  }

  /**
   * @test
   * @expectedException \App\Exception\UnknownCommandException
   * @expectedExceptionMessage The command "/unknown" is not known to the system.
   */
  public function givenUnknownCommandWithArgumentsThrowsException() {
    $this->socket->close();
    CommandFactory::create($this->chatConnection, '/unknown foo bar');
  }

}
