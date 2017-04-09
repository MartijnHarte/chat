<?php

namespace App;

use App\Value\User;
use React\Socket\ConnectionInterface;

class ChatConnection implements ChatConnectionInterface {
  /** @var \React\Socket\ConnectionInterface */
  private $connection;
  /** @var \App\ChatServer */
  private $chatServer;

  /**
   * ChatConnection constructor.
   * @param \React\Socket\ConnectionInterface $connection
   * @param \App\ChatServer $chatServer
   */
  public function __construct(ConnectionInterface $connection, ChatServer $chatServer) {
    $this->connection = $connection;
    $this->chatServer = $chatServer;

    $this->writeMessage("Welcome to this amazing chatserver!");
    $this->writeLineSeparator();
    $this->promptForUsername();

    $this->connection->on('data', function ($data) {
      $user = new User(trim($data));
      $this->welcomeUser($user);
    });
  }

  /**
   * @param string $message
   */
  private function writeMessage($message) {
    $this->connection->write("{$message}\n");
  }

  protected function promptForUsername() {
    $this->writeMessage("Please enter your username:");
  }

  private function writeLineSeparator() {
    $this->writeMessage(str_repeat('#', 100));
  }

  /**
   * @param \App\Value\User $user
   */
  private function welcomeUser(User $user) {
    $this->writeMessage("Welcome, {$user->getUserName()}. There are currently {$this->chatServer->getNumberOfConnectedUsers()} user(s) connected.");
    $this->writeLineSeparator();
  }
}