<?php

namespace App\Tests;

use App\Value\PortNumber;
use PHPUnit_Framework_TestCase;

class PortNumberTest extends PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage Port number should only contain digits.
   */
  public function givenInvalidPortNumberThrowsException() {
    new PortNumber('foo');
  }

  /**
   * @test
   */
  public function givenValidPortNumberAsIntegerReturnsGivenPortNumber() {
    $portNumber = new PortNumber(8000);
    $this->assertEquals(8000, $portNumber->getPortNumber());
  }

  /**
   * @test
   */
  public function givenValidPortNumberAsStringReturnsGivenPortNumber() {
    $portNumber = new PortNumber('8000');
    $this->assertEquals('8000', $portNumber->getPortNumber());
  }

  /**
   * @test
   */
  public function givenNoPortNumberReturnsDefaultPortNumber() {
    $portNumber = new PortNumber();
    $this->assertEquals(8080, $portNumber->getPortNumber());
  }

}
