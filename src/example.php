<?php

use Annovent\Event\Dispatcher;
use Annovent\Event\Event;

include_once 'Annovent/bootstrap.php';

include_once 'EchoListener.php';

$dispatcher = new Dispatcher();
$dispatcher->registerListener(new EchoListener());

$event = new Event('general.preRun', array('argument1' => 'arg1','argument2' => 'arg2'));
$dispatcher->notify($event);