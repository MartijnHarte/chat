<?php

namespace App;

use App\Value\User;

interface ChatServerInterface {

  /**
   * @param \App\Value\User $user
   * @return bool
   */
  public function userHasBeenConnected(User $user);

  /**
   * @return array
   */
  public function getConnectedUsers();

  /**
   * @param \App\Value\User $user
   */
  public function connectUser(User $user);

  /**
   * @return \App\ChatConnectionInterface[]
   */
  public function getConnections();
}