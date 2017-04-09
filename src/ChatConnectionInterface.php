<?php

namespace App;

use App\Value\User;

interface ChatConnectionInterface {

  /**
   * @param string $message
   */
  public function writeMessage($message);

  /**
   * @param \App\Value\User $user
   * @param string $message
   */
  public function writeUserMessage(User $user, $message);

  public function end();
}