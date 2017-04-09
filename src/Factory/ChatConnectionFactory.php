<?php

namespace App\Factory;

use App\ChatConnection;
use React\Socket\ConnectionInterface;

class ChatConnectionFactory {

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @return \App\ChatConnection
   */
  public static function create(ConnectionInterface $connection) {
    return new ChatConnection($connection);
  }

}