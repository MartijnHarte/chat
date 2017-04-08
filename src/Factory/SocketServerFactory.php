<?php

namespace App\Factory;

use App\Value\PortNumberInterface;
use React\EventLoop\LoopInterface;
use React\Socket\Server;

class SocketServerFactory {

  /**
   * @param \App\Value\PortNumberInterface $portNumber
   * @param \React\EventLoop\LoopInterface $loop
   * @return \React\Socket\ServerInterface
   */
  public static function create(PortNumberInterface $portNumber, LoopInterface $loop) {
    return new Server($portNumber->getPortNumber(), $loop);
  }

}