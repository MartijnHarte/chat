<?php

namespace App\Factory;

use App\ChatConnectionInterface;
use App\Command\HelpCommand;
use App\Command\QuitCommand;
use App\Exception\UnknownCommandException;

class CommandFactory {

  /**
   * @param \App\ChatConnectionInterface $chatConnection
   * @param string $data
   * @return \App\Command\CommandInterface
   * @throws \App\Exception\UnknownCommandException
   */
  public static function create(ChatConnectionInterface $chatConnection, $data) {
    $command = $data;
    if (self::commandHasArguments($data)) {
      $command = self::getCommandFromData($data);
    }

    switch ($command) {
      case '/help':
        return new HelpCommand($chatConnection);
      case '/quit':
        return new QuitCommand($chatConnection);
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