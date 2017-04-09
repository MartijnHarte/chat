<?php

namespace App\Command;

use App\ChatConnectionInterface;

class QuitCommand implements CommandInterface {
  /** @var \App\ChatConnectionInterface */
  private $connection;

  /**
   * @param \App\ChatConnectionInterface $chatConnection
   */
  public function __construct(ChatConnectionInterface $chatConnection) {
    $this->connection = $chatConnection;
  }

  public function execute() {
    $this->connection->end();
  }
}