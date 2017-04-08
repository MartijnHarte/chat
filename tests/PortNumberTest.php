<?php

namespace App\Tests;

use App\PortNumber;
use PHPUnit_Framework_TestCase;

class PortNumberTest extends PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage Port number is expected to be of type integer.
   */
  public function givenPortNumberOfInvalidTypeThrowsException() {
    new PortNumber('8000');
  }

  /**
   * @test
   */
  public function givenValidPortNumberReturnsGivenPortNumber() {
    $portNumber = new PortNumber(8000);
    $this->assertEquals(8000, $portNumber->getPortNumber());
  }

  /**
   * @test
   */
  public function givenNoPortNumberReturnsDefaultPortNumber() {
    $portNumber = new PortNumber();
    $this->assertEquals(8080, $portNumber->getPortNumber());
  }

}