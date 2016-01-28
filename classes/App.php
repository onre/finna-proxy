<?php

class App
{
  public function run()
  {
    header('Content-Type: text/xml');

    $api = new Api;

    if ($_GET['operation'] == 'searchRetrieve') {
      echo $api->searchRetrieveRequest($_GET);
    }
  }
}