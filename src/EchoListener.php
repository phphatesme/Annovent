<?php

use Annovent\Event\Listener;

class EchoListener implements Listener
{
  /**
   * @event general.preRun
   */
  public function generalPreRun($argument2, $argument1)
  {
    echo 'argument1: '.$argument1."\n";
    echo 'argument2: '.$argument2."\n";
  }
}