<?php

namespace App\Value;

use InvalidArgumentException;

class User {

  /**
   * @param string $userName
   */
  public function __construct($userName) {
    if (!$this->isValidUserName($userName)) {
      throw new InvalidArgumentException("A username is should contain only alphabetical characters, numbers and underscores.");
    }
  }

  /**
   * @param string $userName
   * @return bool
   */
  private function isValidUserName($userName) {
    return (bool) preg_match('{^[\w]+$}', $userName, $matches);
  }
}