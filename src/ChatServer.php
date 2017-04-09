<?php

namespace App;

use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;

class ChatServer {
  /** @var int */
  private $numberOfConnectedUsers;
  /** @var string */
  private $userName;

  /**
   * @param \React\Socket\ServerInterface $socket
   * @param \React\EventLoop\LoopInterface $loop
   */
  public function __construct(ServerInterface $socket, LoopInterface $loop) {
    $socket->on('connection', function (ConnectionInterface $connection) {
      $this->numberOfConnectedUsers++;
      $this->openConnection($connection);

      $connection->on('data', function ($data) use ($connection) {
        $this->userName = trim($data);
        $this->writeMessage($connection, "Welcome, {$this->userName}. There are currently {$this->getNumberOfConnectedUsers()} user(s) connected.");
        $this->writeLineSeparator($connection);
      });
    });
  }

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  protected function openConnection(ConnectionInterface $connection) {
    $this->writeMessage($connection, "Welcome to this amazing chatserver!");
    $this->writeLineSeparator($connection);
    $this->writeMessage($connection, "Please enter your username:");
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

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  private function writeLineSeparator(ConnectionInterface $connection) {
    $this->writeMessage($connection, str_repeat('#', 100));
  }
}