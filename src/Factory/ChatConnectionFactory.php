<?php

namespace App\Factory;

use App\ChatConnection;
use App\ChatServer;
use React\Socket\ConnectionInterface;

class ChatConnectionFactory {

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @param \App\ChatServer $chatServer
   * @return \App\ChatConnection
   */
  public function create(ConnectionInterface $connection, ChatServer $chatServer) {
    return new ChatConnection($connection, $chatServer);
  }

}