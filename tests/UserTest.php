<?php

namespace App\Tests;

use App\Value\User;

class UserTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage A username is should contain only alphabetical characters, numbers and underscores.
   */
  public function canInstantiateUser() {
    new User('^@%^&%@!*%#@*&a!$@');
  }

}
