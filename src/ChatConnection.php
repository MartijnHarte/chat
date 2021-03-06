<?php

namespace App;

use App\Exception\ExistingUserException;
use App\Factory\CommandFactory;
use App\Value\User;
use Exception;
use React\Socket\ConnectionInterface;

class ChatConnection implements ChatConnectionInterface {
  /** @var \React\Socket\ConnectionInterface */
  private $connection;
  /** @var \App\ChatServerInterface */
  private $chatServer;
  /** @var User */
  private $user;

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @param \App\ChatServerInterface $chatServer
   */
  public function __construct(ConnectionInterface $connection, ChatServerInterface $chatServer) {
    $this->connection = $connection;
    $this->chatServer = $chatServer;

    $this->writeMessage("Welcome to this amazing chatserver!");
    $this->writeLineSeparator();

    $this->writeMessage("Please enter your username:");

    $this->connection->on('data', function ($data) {
      try {
        $this->processData(trim($data));
      } catch (Exception $exception) {
        $this->writeErrorMessage($exception->getMessage());
      }
    });
  }

  /**
   * @param string $message
   */
  public function writeMessage($message) {
    $this->connection->write("{$message}\n");
  }

  /**
   * @param string $data
   */
  private function processData($data) {
    if ($this->user) {
      if ($this->isCommand($data)) {
        $this->executeCommand($data);
      }
      else {
        $this->writeUserMessage($this->user, $data);
      }
    }
    else {
      $this->connectUser($data);
    }
  }

  /**
   * @param string $userName
   */
  protected function connectUser($userName) {
    try {
      $user = new User($userName);
      if (!$this->chatServer->userHasBeenConnected($user)) {
        $this->chatServer->connectUser($user);
        $this->user = $user;
        $this->welcomeUser($user);
      }
      else {
        throw new ExistingUserException("The username \"{$user->getUserName()}\" has already been taken.");
      }
    } catch (Exception $exception) {
      $this->writeErrorMessage($exception->getMessage());
      $this->writeMessage("Please enter your username:");
    }
  }

  /**
   * @param $message
   */
  private function writeErrorMessage($message) {
    $this->writeMessage("\033[0;31m{$message}\033[0m");
  }

  private function writeLineSeparator() {
    $this->writeMessage(str_repeat('#', 100));
  }

  /**
   * @param \App\Value\User $user
   */
  private function welcomeUser(User $user) {
    $numberOfConnectedUsers = count($this->chatServer->getConnectedUsers());
    $this->writeMessage("Welcome, {$user->getUserName()}. There are currently {$numberOfConnectedUsers} user(s) connected.");
    $this->writeLineSeparator();
  }

  /**
   * @param \App\Value\User $user
   * @param string $message
   */
  public function writeUserMessage(User $user, $message) {
    $upperCasedUserName = strtoupper($user->getUserName());
    $this->chatServer->sendMessage("{$upperCasedUserName}> {$message}");
  }

  /**
   * @param string $message
   * @return bool
   */
  private function isCommand($message) {
    return substr($message, 0, 1) === '/';
  }

  /**
   * @param string $command
   * @throws \App\Exception\UnknownCommandException
   */
  private function executeCommand($command) {
    $command = CommandFactory::create($this, $command);
    $command->execute();
  }

  public function end() {
    $this->chatServer->disconnectUser($this->user);
    $this->connection->end();
  }
}