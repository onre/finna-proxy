<?php

spl_autoload_register(function($class) {
    include __DIR__.'/classes/'.$class.'.php';
  });

$app = new App;

Log::write(print_r($_REQUEST,1));

$app->run();
