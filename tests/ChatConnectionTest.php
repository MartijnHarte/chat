<?php

namespace App\Tests;

use App\Factory\ChatConnectionFactory;
use App\Factory\SocketServerFactory;
use App\Tests\TestDoubles\ChatServerSpy;
use App\Tests\TestDoubles\ConnectionSpy;
use App\Value\PortNumber;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;

class ChatConnectionTest extends \PHPUnit_Framework_TestCase {
  /** @var ChatServerSpy */
  private $sut;
  /** @var ServerInterface */
  private $socket;

  public function setUp() {
    $loop = Factory::create();
    $this->socket = SocketServerFactory::create(new PortNumber(1337), $loop);
    $this->sut = new ChatServerSpy($this->socket, $loop, new ChatConnectionFactory());
  }

  /**
   * @test
   */
  public function canEstablishConnectionToChatServer() {
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    $this->socket->emit('connection', array($connection));

    $this->assertTrue($this->sut->establishedConnection());
    $this->socket->close();
  }

  /**
   * @test
   */
  public function givenEstablishedConnectionPrintsWelcomeMessage() {
    $connection = new ConnectionSpy();
    $this->emitConnection($connection);

    $this->assertSame("Welcome to this amazing chatserver!", $connection->getFirstWrittenMessage());
    $this->socket->close();
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  private function emitConnection(ConnectionInterface $connection) {
    $this->socket->emit('connection', array($connection));
  }

  /**
   * @test
   */
  public function givenEstablishedConnectionPromptForUsername() {
    $connection = new ConnectionSpy();
    $this->emitConnection($connection);

    $this->assertSame("Please enter your username:", $connection->getMessageByLine(3));
    $this->socket->close();
  }

  /**
   * @test
   */
  public function givenEstablishedConnectionPrintNumberOfTotalConnections() {
    $users = [
      'Martijn',
      'Piet',
      'Jantje'
    ];

    $i = 1;
    foreach ($users as $user) {
      $connection = new ConnectionSpy();
      $this->emitConnection($connection);
      $connection->emit('data', array($user));
      $this->assertSame("Welcome, {$user}. There are currently {$i} user(s) connected.", $connection->getMessageByLine(4));

      $i++;
    }
    $this->socket->close();
  }
}
