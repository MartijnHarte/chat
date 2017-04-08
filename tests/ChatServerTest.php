<?php

namespace App\Tests;

use App\Factory\SocketServerFactory;
use App\Tests\TestDoubles\ChatServerSpy;
use App\Value\PortNumber;
use PHPUnit_Framework_TestCase;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;

class ChatServerTest extends PHPUnit_Framework_TestCase {
  /** @var ChatServerSpy */
  private $sut;
  /** @var ServerInterface */
  private $socket;

  public function setUp() {
    $loop = Factory::create();
    $this->socket = SocketServerFactory::create(new PortNumber(1337), $loop);
    $this->sut = new ChatServerSpy($this->socket, $loop);
  }

  /**
   * @test
   */
  public function canEstablishConnectionToChatServer() {
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    $this->emitConnection($connection);

    $this->assertTrue($this->sut->establishedConnection());
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  private function emitConnection(ConnectionInterface $connection) {
    $this->socket->emit('connection', array($connection));
  }

}
