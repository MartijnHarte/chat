<?php

namespace App;

use InvalidArgumentException;

class PortNumber {
  /** @var int */
  private $portNumber;

  /**
   * @param int $portNumber
   */
  public function __construct($portNumber) {
    if (is_int($portNumber)) {
      $this->portNumber = $portNumber;
    }
    else {
      throw new InvalidArgumentException("Port number is expected to be of type integer.");
    }
  }

  /**
   * @return int
   */
  public function getPortNumber() {
    return $this->portNumber;
  }
}