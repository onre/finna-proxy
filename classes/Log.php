<?php

class Log
{
  public function write($msg)
  {
    if (!is_string($msg))
      $msg = print_r($msg, 1);
    $msg = date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL;
    error_log($msg, 3, __DIR__.'/../logs/proxy.log');
  }
}