<?php

namespace App\Command;

use React\Socket\ConnectionInterface;

class QuitCommand implements CommandInterface {
  /** @var \React\Socket\ConnectionInterface */
  private $connection;

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  public function __construct(ConnectionInterface $connection) {
    $this->connection = $connection;
  }

  public function execute() {
    $this->connection->close();
  }
}