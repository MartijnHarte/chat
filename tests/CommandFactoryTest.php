<?php

namespace App\Tests;

use App\Factory\CommandFactory;

class CommandFactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \App\Exception\UnknownCommandException
   * @expectedExceptionMessage The command "/unknown" is not known to the system.
   */
  public function givenUnknownCommandThrowsException() {
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    CommandFactory::create($connection, '/unknown');
  }

  /**
   * @test
   * @expectedException \App\Exception\UnknownCommandException
   * @expectedExceptionMessage The command "/unknown" is not known to the system.
   */
  public function givenUnknownCommandWithArgumentsThrowsException() {
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    CommandFactory::create($connection, '/unknown foo bar');
  }

}
