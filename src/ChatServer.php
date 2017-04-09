<?php

namespace App;

use App\Factory\ChatConnectionFactory;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;

class ChatServer {
  /** @var int */
  private $numberOfConnectedUsers;

  /**
   * @param \React\Socket\ServerInterface $socket
   * @param \React\EventLoop\LoopInterface $loop
   * @param \App\Factory\ChatConnectionFactory $chatConnectionFactory
   */
  public function __construct(ServerInterface $socket, LoopInterface $loop, ChatConnectionFactory $chatConnectionFactory) {
    $socket->on('connection', function (ConnectionInterface $connection) use ($chatConnectionFactory) {
      $this->openConnection($connection, $chatConnectionFactory);
    });
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @param \App\Factory\ChatConnectionFactory $chatConnectionFactory
   */
  protected function openConnection(ConnectionInterface $connection, ChatConnectionFactory $chatConnectionFactory) {
    $this->numberOfConnectedUsers++;
    $chatConnectionFactory->create($connection, $this);
  }

  /**
   * @return int
   */
  public function getNumberOfConnectedUsers() {
    return $this->numberOfConnectedUsers;
  }
}