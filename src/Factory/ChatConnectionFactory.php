<?php

namespace App\Factory;

use App\ChatConnection;
use App\ChatServerInterface;
use React\Socket\ConnectionInterface;

class ChatConnectionFactory {

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @param \App\ChatServerInterface $chatServer
   * @return \App\ChatConnection
   */
  public function create(ConnectionInterface $connection, ChatServerInterface $chatServer) {
    return new ChatConnection($connection, $chatServer);
  }

}