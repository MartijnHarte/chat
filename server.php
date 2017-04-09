<?php

require __DIR__ . '/vendor/autoload.php';

use App\ChatServer;
use App\Factory\ChatConnectionFactory;
use App\Factory\SocketServerFactory;
use App\Value\PortNumber;
use React\EventLoop\Factory;

$portNumberArgument = isset($argv[1]) ? $argv[1] : 8080;
$loop = Factory::create();
$socket = SocketServerFactory::create(new PortNumber($portNumberArgument), $loop);

$chatServer = new ChatServer($socket, $loop, new ChatConnectionFactory());
$loop->run();