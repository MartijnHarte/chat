<?php

namespace App\Tests\TestDoubles;

use Evenement\EventEmitter;
use React\Socket\ConnectionInterface;
use React\Stream\WritableStreamInterface;
use React\Stream\Util;

class ConnectionSpy extends EventEmitter implements ConnectionInterface {
  private $data = '';

  /**
   * @return string
   */
  public function getFirstWrittenMessage() {
    $messages = $this->getWrittenMessages();
    return reset($messages);
  }

  /**
   * @return string
   */
  public function getLastWrittenMessage() {
    $messages = $this->getWrittenMessages();
    return end($messages);
  }

  /**
   * @return array
   */
  public function getWrittenMessages() {
    return array_filter(explode("\n", $this->data));
  }

  public function isReadable() {
    return TRUE;
  }

  public function isWritable() {
    return TRUE;
  }

  public function pause() {
  }

  public function resume() {
  }

  public function pipe(WritableStreamInterface $dest, array $options = array()) {
    Util::pipe($this, $dest, $options);

    return $dest;
  }

  public function write($data) {
    $this->data .= $data;

    return TRUE;
  }

  public function end($data = NULL) {
  }

  public function close() {
  }

  public function getData() {
    return $this->data;
  }

  public function getRemoteAddress() {
    return '127.0.0.1';
  }

  public function getLocalAddress() {
    // Stub.
  }
}
