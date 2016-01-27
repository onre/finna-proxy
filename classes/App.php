<?php

class App
{
  public function run()
  {
    try {
      $server = new SoapServer(NULL, array('uri' => 'http://finna-proxy.anteek.fi/'));
      
      $server->setClass('Api');
      $server->handle();

    } catch (SOAPFault $f) {
      Log::write($f->faultstring);
    }
  }
}