<?php

namespace App;

use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;

class ChatServer {
  /** @var int */
  private $numberOfConnectedUsers;

  /**
   * @param \React\Socket\ServerInterface $socket
   * @param \React\EventLoop\LoopInterface $loop
   */
  public function __construct(ServerInterface $socket, LoopInterface $loop) {
    $socket->on('connection', function (ConnectionInterface $connection) {
      $this->numberOfConnectedUsers++;
      $this->openConnection($connection);
    });
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  protected function openConnection(ConnectionInterface $connection) {
    $this->writeMessage($connection, "Welcome to this amazing chatserver!");
    $this->writeMessage($connection, sprintf("There are currently %d user(s) connected.", $this->getNumberOfConnectedUsers()));
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @param string $message
   */
  private function writeMessage(ConnectionInterface $connection, $message) {
    $connection->write("{$message}\n");
  }

  /**
   * @return int
   */
  private function getNumberOfConnectedUsers() {
    return $this->numberOfConnectedUsers;
  }
}