<?php

namespace App\Tests;

use App\Value\User;

class UserTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage A username should contain only alphabetical characters, numbers and underscores.
   */
  public function givenInvalidUserNameThrowsException() {
    new User('^@%^&%@!*%#@*&a!$@');
  }

  /**
   * @test
   */
  public function canInstantiateUser() {
    new User('Martijn_123');
  }

  /**
   * @test
   */
  public function givenValidUserNameReturnsGivenUserName() {
    $userName = 'Martijn';
    $user = new User($userName);

    $this->assertSame($userName, $user->getUserName());
  }

}
