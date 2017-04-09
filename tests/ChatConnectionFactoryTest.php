<?php

namespace App\Tests;

use App\ChatConnection;
use App\Factory\ChatConnectionFactory;

class ChatConnectionFactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function factoryReturnsConnection() {
    $connection = $this->getMockBuilder('React\Socket\ConnectionInterface')
      ->getMock();
    $chatConnection = ChatConnectionFactory::create($connection);

    $this->assertInstanceOf(ChatConnection::class, $chatConnection);
  }
}
