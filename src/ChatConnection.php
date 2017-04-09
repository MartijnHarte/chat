<?php

namespace App;

use App\Exception\ExistingUserException;
use App\Value\User;
use Exception;
use React\Socket\ConnectionInterface;

class ChatConnection implements ChatConnectionInterface {
  /** @var \React\Socket\ConnectionInterface */
  private $connection;
  /** @var \App\ChatServer */
  private $chatServer;

  /**
   * ChatConnection constructor.
   * @param \React\Socket\ConnectionInterface $connection
   * @param \App\ChatServerInterface $chatServer
   */
  public function __construct(ConnectionInterface $connection, ChatServerInterface $chatServer) {
    $this->connection = $connection;
    $this->chatServer = $chatServer;

    $this->writeSystemMessage("Welcome to this amazing chatserver!");
    $this->writeLineSeparator();
    $this->promptForUsername();
  }

  /**
   * @param string $message
   */
  private function writeSystemMessage($message) {
    $this->connection->write("{$message}\n");
  }

  protected function promptForUsername() {
    $userNamePromptMessage = "Please enter your username:";
    $this->writeSystemMessage($userNamePromptMessage);

    $this->connection->on('data', function ($data) use ($userNamePromptMessage) {
      try {
        $user = new User(trim($data));
        if (!$this->chatServer->userHasBeenConnected($user)) {
          $this->chatServer->connectUser($user);
          $this->welcomeUser($user);
        }
        else {
          throw new ExistingUserException("The username \"{$user->getUserName()}\" has already been taken.");
        }
      } catch (Exception $exception) {
        $this->writeErrorMessage($exception->getMessage());
        $this->writeSystemMessage($userNamePromptMessage);
      }
    });
  }

  /**
   * @param $message
   */
  private function writeErrorMessage($message) {
    $this->writeSystemMessage("\033[0;31m{$message}\033[0m");
  }

  private function writeLineSeparator() {
    $this->writeSystemMessage(str_repeat('#', 100));
  }

  /**
   * @param \App\Value\User $user
   */
  private function welcomeUser(User $user) {
    $numberOfConnectedUsers = count($this->chatServer->getConnectedUsers());
    $this->writeSystemMessage("Welcome, {$user->getUserName()}. There are currently {$numberOfConnectedUsers} user(s) connected.");
    $this->writeLineSeparator();
  }
}