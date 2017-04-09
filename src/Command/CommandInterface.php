<?php

namespace App\Command;

use App\ChatConnectionInterface;

interface CommandInterface {

  /**
   * @param \App\ChatConnectionInterface $chatConnection
   */
  public function __construct(ChatConnectionInterface $chatConnection);

  public function execute();
}