<?php

namespace App\Tests\TestDoubles;

use App\ChatServer;
use App\Factory\ChatConnectionFactory;
use React\Socket\ConnectionInterface;

class ChatServerSpy extends ChatServer {
  /** @var bool */
  private $connected = FALSE;

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  protected function openConnection(ConnectionInterface $connection, ChatConnectionFactory $chatConnectionFactory) {
    $this->connected = TRUE;
    parent::openConnection($connection, $chatConnectionFactory);
  }

  /**
   * @return bool
   */
  public function establishedConnection() {
    return $this->connected;
  }

}