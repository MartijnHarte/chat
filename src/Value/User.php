<?php

namespace App\Value;

use InvalidArgumentException;

class User {

  /**
   * @param string $userName
   */
  public function __construct($userName) {
    if ($this->isValidUserName($userName)) {
      $this->userName = $userName;
    }
    else {
      throw new InvalidArgumentException("A username should contain only alphabetical characters, numbers and underscores.");
    }
  }

  /**
   * @return string
   */
  public function getUserName() {
    return $this->userName;
  }

  /**
   * @param string $userName
   * @return bool
   */
  private function isValidUserName($userName) {
    return (bool) preg_match('{^[\w]+$}', $userName, $matches);
  }
}