<?php

namespace App\Command;

use React\Socket\ConnectionInterface;

interface CommandInterface {

  /**
   * @param \React\Socket\ConnectionInterface $connection
   */
  public function __construct(ConnectionInterface $connection);

  public function execute();
}