<?php

namespace App;

use React\Socket\ConnectionInterface;

class ChatConnection {
  /** @var \React\Socket\ConnectionInterface */
  private $connection;

  /**
   * ChatConnection constructor.
   * @param \React\Socket\ConnectionInterface $connection
   */
  public function __construct(ConnectionInterface $connection) {
    $this->connection = $connection;
  }
}