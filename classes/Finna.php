<?php

class Finna
{
  protected $apiBaseUrl = 'https://api.finna.fi/v1/';

  public function search($query, $options = array())
  {
    $options['lookfor'] = $query;
    $options['field'] = ['fullRecord'];

    return $this->query('search', $options);
  }

  public function query($action, $params)
  {
    Log::write($this->apiBaseUrl.$action.'?'.http_build_query($params));
    return json_decode(file_get_contents($this->apiBaseUrl.$action.'?'.http_build_query($params)), 1);
  }
}