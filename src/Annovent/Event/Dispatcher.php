<?php

namespace Annovent\Event;

class Dispatcher
{
  private $eventListenerMatrix = array();
  
  public function notify(Event $event)
  {
    if (array_key_exists($event->getName(), $this->eventListenerMatrix))
    {
      foreach ($this->eventListenerMatrix[$event->getName()] as $listenerInfo)
      {
        $listener = $listenerInfo['listener'];
        $method = $listenerInfo['method'];
        
        \call_user_func_named_array(array($listener,$method), $event->getParameters());
      }
    }
  }
  
  public function notityUntil(Event $event)
  {
    if (array_key_exists($event->getName(), $this->eventListenerMatrix))
    {
      foreach ($this->eventListenerMatrix[$event->getName()] as $listenerInfo)
      {
        $listener = $listenerInfo['listener'];
        $method = $listenerInfo['method'];
        
        if( !\call_user_func_named_array(array($listener,$method), $event->getParameters()) ) {
          return false;
        }
      }
    }
    return true;
  }
  
  public function registerListener(Listener $listener)
  {
    $reflectedListener = new \ReflectionClass($listener);
    
    foreach ($reflectedListener->getMethods() as $reflectedMethod)
    {
      if ($reflectedMethod->isPublic())
      {
        $docComment = $reflectedMethod->getDocComment();
        $annotationFound = preg_match('^@event(.*)^', $docComment, $matches);
        
        if ($annotationFound)
        {
          $eventName = substr($matches[1], 1, strlen($matches[1]) - 2);
          
          $listenerInfo = array('listener' => $listener,'method' => $reflectedMethod->getName());
          
          $this->eventListenerMatrix[$eventName][] = $listenerInfo;
        }
      }
    }
  }
}