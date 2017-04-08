<?php

namespace App;

use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;

class ChatServer {

  /**
   * @param \React\Socket\ServerInterface $socket
   * @param \React\EventLoop\LoopInterface $loop
   */
  public function __construct(ServerInterface $socket, LoopInterface $loop) {
    $socket->on('connection', function (ConnectionInterface $connection) {
      $this->openConnection($connection);
    });
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  protected function openConnection(ConnectionInterface $connection) {
    $this->writeMessage($connection, "Welcome to this amazing chatserver!");
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @param string $message
   */
  private function writeMessage(ConnectionInterface $connection, $message) {
    $connection->write("{$message}\n");
  }
}