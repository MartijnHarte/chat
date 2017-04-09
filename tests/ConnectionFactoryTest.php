<?php

namespace App\Tests;

use App\ChatConnection;
use App\Factory\ConnectionFactory;

class ConnectionFactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function factoryReturnsConnection() {
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    $chatConnection = ConnectionFactory::create($connection);

    $this->assertInstanceOf(ChatConnection::class, $chatConnection);
  }
}
