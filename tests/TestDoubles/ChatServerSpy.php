<?php

namespace App\Tests\TestDoubles;

use App\ChatServer;
use React\Socket\ConnectionInterface;

class ChatServerSpy extends ChatServer {
  /** @var bool */
  private $connected = FALSE;

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  protected function openConnection(ConnectionInterface $connection) {
    $this->connected = TRUE;
    parent::openConnection($connection);
  }

  /**
   * @return bool
   */
  public function establishedConnection() {
    return $this->connected;
  }

}