<?php

namespace App\Command;

use App\ChatConnectionInterface;

class HelpCommand implements CommandInterface {
  /** @var \React\Socket\ConnectionInterface */
  private $connection;

  /**
   * @param \App\ChatConnectionInterface $chatConnection
   */
  public function __construct(ChatConnectionInterface $chatConnection) {
    $this->connection = $chatConnection;
  }

  public function execute() {
    $this->connection->writeMessage('Here to help!');
  }
}