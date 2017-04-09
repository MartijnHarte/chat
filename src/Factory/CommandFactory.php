<?php

namespace App\Factory;

use App\Exception\UnknownCommandException;

class CommandFactory {

  /**
   * @param string $data
   */
  public static function create($data) {
    $command = $data;
    if (self::commandHasArguments($data)) {
      $command = self::getCommandFromData($data);
    }

    if ($command !== '/quit') {
      throw new UnknownCommandException("The command \"{$command}\" is not known to the system.");
    }
  }

  /**
   * @param string $data
   * @return bool
   */
  private static function commandHasArguments($data) {
    return strpos($data, ' ') !== FALSE;
  }

  /**
   * @param string $data
   * @return string
   */
  private static function getCommandFromData($data) {
    $command = explode(' ', $data, 2);
    return $command[0];
  }

}