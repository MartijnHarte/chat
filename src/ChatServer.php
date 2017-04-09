<?php

namespace App;

use App\Factory\ChatConnectionFactory;
use App\Value\User;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;

class ChatServer implements ChatServerInterface {
  /** @var array */
  private $connectedUsers = [];

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
    $chatConnectionFactory->create($connection, $this);
  }

  /**
   * @param \App\Value\User $user
   * @return bool
   */
  public function userHasBeenConnected(User $user) {
    return in_array($user->getUserName(), $this->getConnectedUsers());
  }

  /**
   * @return array
   */
  public function getConnectedUsers() {
    return $this->connectedUsers;
  }

  /**
   * @param \App\Value\User $user
   */
  public function connectUser(User $user) {
    $this->connectedUsers[] = $user->getUserName();
  }
}