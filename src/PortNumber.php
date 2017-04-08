<?php

namespace App;

use InvalidArgumentException;

class PortNumber {
  /** @var int */
  private $portNumber;

  /**
   * @param int $portNumber
   */
  public function __construct($portNumber = 8080) {
    if (preg_match('{[\d]+}', $portNumber, $matches)) {
      $this->portNumber = $portNumber;
    }
    else {
      throw new InvalidArgumentException("Port number should only contain digits.");
    }
  }

  /**
   * @return int
   */
  public function getPortNumber() {
    return $this->portNumber;
  }
}