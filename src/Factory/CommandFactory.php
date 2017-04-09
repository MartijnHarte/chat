<?php

namespace App\Factory;

use App\Command\HelpCommand;
use App\Command\QuitCommand;
use App\Exception\UnknownCommandException;
use React\Socket\ConnectionInterface;

class CommandFactory {

  /**
   * @param \React\Socket\ConnectionInterface $connection
   * @param string $data
   * @return \App\Command\CommandInterface
   * @throws \App\Exception\UnknownCommandException
   */
  public static function create(ConnectionInterface $connection, $data) {
    $command = $data;
    if (self::commandHasArguments($data)) {
      $command = self::getCommandFromData($data);
    }

    switch ($command) {
      case '/help':
        return new HelpCommand($connection);
      case '/quit':
        return new QuitCommand($connection);
        break;
      default:
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